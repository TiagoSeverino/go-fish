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
        if(isset( $_SESSION['user'])){
            var_dump($_SESSION['user']);
            Throw new Exception("session detectada: " . $_SESSION['user']->id);
        }else{
            //Throw new Exception("sessão não existe");
        }
        return View::make('home.index');
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
            Redirect::toRoute('home/index');
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

        if(Utilizadores::find(["Username"=>Post::get('Username')])){

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

}