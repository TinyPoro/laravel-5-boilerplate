<?php
/**
 * Created by PhpStorm.
 * Chef: tinyporo
 * Date: 20/03/2018
 * Time: 16:29
 */
namespace App\Creational\FactoryMethod;

abstract class Chef{
    public static function chooseCookieChef(){
        return new CookieChef();
    }

    public static function chooseIceChef(){
        return new IceChef();
    }

    public abstract function makeFood();
}