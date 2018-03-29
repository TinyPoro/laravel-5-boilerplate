<?php
/**
 * Created by PhpStorm.
 * Chef: tinyporo
 * Date: 20/03/2018
 * Time: 16:31
 */
namespace App\Creational\AbstractFactory;
class IceDrink extends Drink
{
    public function __construct(){
        $this->name = "đồ uống lạnh";
    }
}