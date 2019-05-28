<?php
/**
 * Created by PhpStorm.
 * Utilizadores: João
 * Date: 26/04/2019
 * Time: 11:58
 */


use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\View;


class PlanoController extends BaseController
{
    public function index(){

        return View::make('plano.index');
    }
}