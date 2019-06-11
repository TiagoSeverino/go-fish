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

    public function index(){

        $islogin = isset( $_SESSION['user']);
        if($islogin == true){
            $this->showgame();
        }else {
            Redirect::toRoute('home/login');
        }
    }

    public function login(){
        if(isset($_SESSION['user'])){
            Redirect::toRoute('home/index');
        }else{
            return View::make('home.login', ['valid' => true]);
        }
    }

    public function dologin(){
        $user = Utilizadores::find(Post::getAll());

        if($user){
            Session::set('user', $user);
            Redirect::toRoute('home/index');
        }
        else{
            return View::make('home.login', ['valid' => false]);
        }
    }

    public function register(){

        if(isset($_SESSION['user'])){
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
        $islogin = isset( $_SESSION['user']);
        return View::make('home.profile', ['utilizador' => Session::get('user'), 'islogin' => $islogin]);
    }

    public function updateProfile()
    {
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
        $islogin = isset( $_SESSION['user']);

        /* como selecionar os 10 primeiros users ordenados pelas vitorias a partir da base de dados */
        $options = array('limit' => 10, 'order' => 'numerovitorias desc, numerojogos asc');
        $users = Utilizadores::find('all',$options);

        return View::make('home.stats', ['islogin' => $islogin, 'users' => $users]);

    }

    function showgame() {

        //Create new game engine
        $game = new FishGameEngine();

        if(isset($_SESSION['game'])){
            $game = Session::get('game');
        }
        else
        {
            Session::set('game', $game);
        }

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

        $islogin = isset( $_SESSION['user']);

        if ($game->isFinished()){
            return View::make('home.GameFinished', ['game' => $game, 'won' => ($game->getPlayerPoints() > $game->getBotPoints())]);
        }
        else
        {
            return View::make('home.GoFish', ['game' => $game,'islogin' => $islogin]);
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
        $game = new FishGameEngine();
        Session::set('game', $game);

        Redirect::toRoute('home/index');
    }

    public function admin() {
        $islogin = isset( $_SESSION['user']);

        if ($islogin && Session::get('user')->isadmin){
            return View::make('home.admin', ['islogin' => $islogin, 'users' => Utilizadores::all()]);
        }else{
            Redirect::toRoute('home/index');
        }



    }


}