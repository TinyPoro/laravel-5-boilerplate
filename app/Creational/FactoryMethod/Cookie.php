<?php
/**
 * Created by PhpStorm.
 * Chef: tinyporo
 * Date: 20/03/2018
 * Time: 16:31
 */
namespace App\Creational\FactoryMethod;

class Cookie
{
    private $name;
    public function __construct(){
        $this->name = "bánh";
    }

    public function toString(){
        echo "Sản xuất $this->name\n";
    }
}