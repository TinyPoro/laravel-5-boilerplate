<?php
/**
 * Created by PhpStorm.
 * Chef: tinyporo
 * Date: 20/03/2018
 * Time: 16:43
 */
namespace App\Creational\AbstractFactory;
class IceChef extends Chef
{
    public function makeFood() {
        $ice = new Icescream();
        $ice->toString();
    }

    public function makeDrink()
    {
        $drink = new IceDrink();
        $drink->toString();
    }
}