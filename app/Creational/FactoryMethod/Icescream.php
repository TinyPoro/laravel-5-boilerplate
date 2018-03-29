<?php
/**
 * Created by PhpStorm.
 * Chef: tinyporo
 * Date: 20/03/2018
 * Time: 16:31
 */
namespace App\Creational\FactoryMethod;
class Icescream
{
    private $name;

    public function __construct(){
        $this->name = "kem";
    }

    public function toString(){
        echo "Sản xuất $this->name\n";
    }
}