<?php
/**
 * Created by PhpStorm.
 * Chef: tinyporo
 * Date: 20/03/2018
 * Time: 16:31
 */
namespace App\Creational\AbstractFactory;

class CookieDrink extends Drink
{
    public function __construct(){
        $this->name = "đồ uống kèm bánh";
    }
}