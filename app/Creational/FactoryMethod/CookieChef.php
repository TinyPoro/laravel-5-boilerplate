<?php
/**
 * Created by PhpStorm.
 * Chef: tinyporo
 * Date: 20/03/2018
 * Time: 16:41
 */
namespace App\Creational\FactoryMethod;
class CookieChef extends Chef
{
    public function makeFood() {
        $cookie = new Cookie();
        $cookie->toString();
    }
}