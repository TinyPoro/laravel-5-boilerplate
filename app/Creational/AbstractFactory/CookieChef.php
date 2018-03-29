<?php
/**
 * Created by PhpStorm.
 * Chef: tinyporo
 * Date: 20/03/2018
 * Time: 16:41
 */
namespace App\Creational\AbstractFactory;
class CookieChef extends Chef
{
    public function makeFood() {
        $cookie = new Cookie();
        $cookie->toString();
    }

    public function makeDrink()
    {
        $drink = new CookieDrink();
        $drink->toString();
    }
}