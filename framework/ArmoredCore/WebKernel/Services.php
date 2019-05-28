<?php

namespace ArmoredCore\WebKernel;
use ArmoredCore\WebKernel\IOCContainer;

/**
 * Created by PhpStorm.
 * Utilizadores: smendes
 * Date: 11-04-2017
 * Time: 12:04
 */
class Services extends IOCContainer
{

    public static function getComponents()
    {
        return self::$instances;
    }

}