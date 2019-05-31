<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Post;

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
        return View::make('home.index', ['islogin' => $islogin]);
    }

    public function start(){

        //View::attachSubView('titlecontainer', 'layout.pagetitle', ['title' => 'Quick Start']);
        return View::make('home.start');
    }

    public function login(){
        //Throw new Exception('Method not implemented. Do it yourself!');

        if(isset($_SESSION['user'])){
            Redirect::toRoute('home/index');
        }else{
            return View::make('home.login');
        }
    }

    public function dologin(){
        //Throw new Exception('Method not implemented. Do it yourself!');
        $user = Utilizadores::find(Post::getAll());

        if($user){
            Session::set('user', $user);
            Redirect::toRoute('home/GoFish');
        }
        else{
            Throw new Exception('Login Invalido');
            //return View::make('home.index');
        }

        //return View::make('home.login');
    }

    public function register(){

        if(isset($_SESSION['user'])){
            Redirect::toRoute('home/index');
        }else{
            return View::make('home.signup');
        }
    }

    public function doregister(){
        //Throw new Exception('Method not implemented. Do it yourself!');

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

    public function GoFish(){
        return View::make('home.GoFish');
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


    public function worksheet(){

        View::attachSubView('titlecontainer', 'layout.pagetitle', ['title' => 'MVC Worksheet']);

        return View::make('home.worksheet');
    }

    public function setsession(){
        $dataObject = MetaArmCoreModel::getComponents();
        Session::set('object', $dataObject);

        Redirect::toRoute('home/worksheet');
    }

    public function showsession(){
        $res = Session::get('object');
        var_dump($res);
    }

    public function destroysession(){

        Session::destroy();
        Redirect::toRoute('home/worksheet');
    }

    public function about(){

        return View::make('home.about');
    }

    public function showstats(){
        $islogin = isset( $_SESSION['user']);

        /* como selecionar os 10 primeiros users ordenados pelas vitorias a partir da base de dados
        $users = Utilizadores::find_by_sql("SELECT *"); */
        $options = array('limit' => 10, 'order' => 'numerovitorias desc');
        $users = Utilizadores::find('all',$options);

        return View::make('home.stats', ['islogin' => $islogin, 'users' => $users]);

    }

}