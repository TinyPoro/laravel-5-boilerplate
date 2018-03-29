<?php
/**
 * Created by PhpStorm.
 * Chef: tinyporo
 * Date: 20/03/2018
 * Time: 16:31
 */
namespace App\Creational\AbstractFactory;
class Icescream extends Food
{
    public function __construct(){
        $this->name = "kem";
    }
}