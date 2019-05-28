<?php
/**
 * Created by PhpStorm.
 * Utilizadores: smendes
 * Date: 06-04-2017
 * Time: 19:00
 */

namespace ArmoredCore\Interfaces;
/**
 * Created by PhpStorm.
 * Utilizadores: smendes
 * Date: 16-05-2016
 * Time: 14:10
 */
interface LayoutManagerInterface
{
    public function includeLayout($layoutViewName);

    public function setSubViewContainer($subViewName);
}