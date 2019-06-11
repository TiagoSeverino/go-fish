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
        if($islogin == true){
            Redirect::toRoute('home/gofish');
        }else {
            Redirect::toRoute('home/login');
        }
    }

    public function login(){
        if(isset($_SESSION['user'])){
            Redirect::toRoute('home/index');
        }else{
            return View::make('home.login');
        }
    }

    public function dologin(){
        $user = Utilizadores::find(Post::getAll());

        if($user){
            Session::set('user', $user);
            Redirect::toRoute('home/index');
        }
        else{
            Throw new Exception('Login Invalido');
            //return View::make('home.index');
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

}