<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Post;
use Tracy\Debugger;

/**
 * Created by PhpStorm.
 * Utilizadores: smendes
 * Date: 09-05-2016
 * Time: 11:30
 */
class HomeController extends BaseController
{
    public function isLoggedIn(){
        return isset( $_SESSION['user']);
    }

    public function isAdmin(){
        return ($this->isLoggedIn() && Session::get('user')->isadmin == 1);
    }

    public function index(){
        if( $this->isLoggedIn() ){
            $this->showgame();
        }else {
            Redirect::toRoute('home/login');
        }
    }

    public function login(){
        if( $this->isLoggedIn() ){
            Redirect::toRoute('home/index');
        }else{
            return View::make('home.login', ['valid' => true]);
        }
    }

    public function dologin(){
        $user = Utilizadores::find(Post::getAll());

        if($user && $user->isbanned == 0){
            Session::set('user', $user);
            Redirect::toRoute('home/index');
        }
        else{
            return View::make('home.login', ['valid' => false]);
        }
    }

    public function register(){

        if( $this->isLoggedIn() ){
            Redirect::toRoute('home/index');
        }else{
            return View::make('home.signup');
        }
    }

    public function doregister(){
        if(Utilizadores::find(["username"=>Post::get('username')])){

            Redirect::toRoute('home/login');
        }
        else {
            $utilizador = new Utilizadores(Post::getAll());

            if($utilizador->is_valid()){
                $utilizador->save();

                $utilizador = Utilizadores::find(Post::getAll());
                Session::set('user', $utilizador);
                Redirect::toRoute('home/index');
            }else{
                Throw new Exception('Conta inválida');
            }
        }
    }

    public function logout(){

        Session::destroy();
        Redirect::toRoute('home/index');
    }

    public function showProfile(){
        return View::make('home.profile', ['utilizador' => Session::get('user'), 'islogin' =>  $this->isLoggedIn(), 'isadmin' => $this->isAdmin() ]);
    }

    public function updateProfile(){
        $utilizador = Utilizadores::find(Session::get('user')->id);
        $utilizador->update_attributes(Post::getAll());

        if($utilizador->is_valid()){
            $utilizador->save();
            Session::set('user', $utilizador);
            Redirect::toRoute('home/index');
        } else {
            // return form with data and errors
            Redirect::flashToRoute('home/profile', ['user' => $utilizador]);
        }
    }

    public function destroysession(){

        Session::destroy();
        Redirect::toRoute('home/worksheet');
    }

    public function stats(){
        /* como selecionar os 10 primeiros users ordenados pelas vitorias a partir da base de dados */
        $options = array('limit' => 10, 'order' => 'numerovitorias desc, numerojogos asc');
        $users = Utilizadores::find('all',$options);

        return View::make('home.stats', ['islogin' =>  $this->isLoggedIn(), 'users' => $users, 'isadmin' => $this->isAdmin(), ]);

    }

    function showgame() {

        if(!isset($_SESSION['game'])){
            $this-newgame();
            return;
        }

        $game = Session::get('game');

        Debugger::barDump($game);

        if ($game->isFinished() && !$game->updatedDB()){
            $game->updateDB();

            // adicionar 1 jogo a base de dados do jogador
            $user = Utilizadores::find(Session::get('user')->id);
            $user->numerojogos++;

            if ($game->getPlayerPoints() > $game->getBotPoints()){
                //se pontos jogador > pontos do bot adcionar 1 vitoria ao jogador na base de dados
                $user->numerovitorias++;
            }

            $user->save();
        }

        if ($game->isFinished()){
            return View::make('home.GameFinished', ['game' => $game, 'won' => ($game->getPlayerPoints() > $game->getBotPoints())]);
        }
        else
        {
            return View::make('home.GoFish', ['game' => $game,'islogin' =>  $this->isLoggedIn(), 'isadmin' => $this->isAdmin()]);
        }
    }

    function play(){
        $game = Session::get('game');
        Debugger::barDump($game);

        //Ask one card
        $card = new Card('C' . Post::get('card'));
        $result = $game->askForCard($card);
        Debugger::barDump($card, "Carta");
        Debugger::barDump($result, "Carta pedida");

        //verificar se carta pedida existe
        if(count($result) == 0){
            //Go fish and change player
            $newCard = $game->goFish();

            if($newCard->getValue() == $card->getValue()){
                Session::set('game', $game);
                return;
            }

            $game->changeCurrentPlayer();

            $botDone = false;
            while(!$botDone) {
                $botCard = $game->makeBotPlay();
                Debugger::barDump($botCard, "Carta pedida pelo bot");

                if ($botCard == null){
                    $botDone = true;
                    continue;
                }

                $botResult = $game->askForCard($botCard);

                var_dump($botCard->getValue());
                var_dump($botResult);
                if (count($botResult) == 0) {
                    $newCard = $game->goFish();

                    if($newCard->getValue() != $botCard->getValue()){
                        $game->changeCurrentPlayer();
                        $botDone = true;
                    }
                } else {
                    $game->addCardsToHand($botResult);
                }
            }
        } else {
            $game->addCardsToHand($result);
        }

        Session::set('game', $game);
    }

    function newgame() {

        //Create new game engine
        $game = new FishGameEngine(Session::get('user')->cartasiniciais);
        Session::set('game', $game);

        Redirect::toRoute('home/index');
    }

    public function admin() {
        if ( $this->isAdmin() ){
            return View::make('home.admin', ['islogin' => $this->isLoggedIn(), 'isadmin' => $this->isAdmin(), 'users' => Utilizadores::all()]);
        }else{
            Redirect::toRoute('home/index');
        }
    }

    public function edit($id){
        return View::make('home.profile', ['utilizador' => Utilizadores::find($id), 'islogin' =>  $this->isLoggedIn(), 'isadmin' => $this->isAdmin() ]);
    }

    public function doedit($id){
        if ( $this->isAdmin() ){
            $utilizador = Utilizadores::find($id);
            $utilizador->update_attributes(Post::getAll());

            if($utilizador->is_valid()){
                $utilizador->save();
                Redirect::toRoute('home/admin');
            } else {
                Redirect::toRoute('home/edit/' . $id);
            }
        }
    }
}