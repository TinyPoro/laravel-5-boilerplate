<?php
/**
 * Created by PhpStorm.
 * Chef: tinyporo
 * Date: 20/03/2018
 * Time: 16:29
 */
namespace App\Creational\AbstractFactory;

abstract class Chef{
    public static function chooseChef($check){

        if ($check == 1) {
            return new CookieChef();
        }
        else {
            return new IceChef();
        }
    }

    public abstract function makeFood();
    public abstract function makeDrink();
}