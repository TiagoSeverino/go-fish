<?php
/**
 * Created by PhpStorm.
 * Utilizadores: smendes
 * Date: 02-05-2016
 * Time: 11:18
 */
use ArmoredCore\Facades\Router;

/****************************************************************************
 *  URLEncoder/HTTPRouter Routing Rules
 *  Use convention: controllerName@methodActionName
 ****************************************************************************/

Router::get('/',			'HomeController/index');
Router::get('home/',		'HomeController/index');
Router::get('home/index',	'HomeController/index');
Router::get('home/start',	'HomeController/start');
Router::get('home/about', 'HomeController/about');
Router::post('home/index', 'HomeController/index');

Router::get('home/login', 'HomeController/login');
Router::post('home/login', 'HomeController/dologin');

Router::get('home/signup', 'HomeController/register');
Router::post('home/signup', 'HomeController/doregister');
Router::get('home/logout', 'HomeController/logout');

Router::get('home/GoFish', 'HomeController/GoFish');
Router::get('home/profile', 'HomeController/showProfile');
Router::post('home/profile', 'HomeController/updateProfile');

Router::get('home/stats', 'HomeController/showstats');









/************** End of URLEncoder Routing Rules ************************************/