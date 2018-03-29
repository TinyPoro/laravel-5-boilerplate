<?php
/**
 * Created by PhpStorm.
 * Chef: tinyporo
 * Date: 20/03/2018
 * Time: 16:33
 */
namespace App\Creational\AbstractFactory;
abstract class Drink
{
    protected $name;

    public function __construct(){
    }

    public function toString(){
        echo "Sản xuất $this->name\n";
    }
}