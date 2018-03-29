<?php
/**
 * Created by PhpStorm.
 * Chef: tinyporo
 * Date: 21/03/2018
 * Time: 22:33
 */

namespace App\Structural;


class IceAdapter implements Food
{
    private $icescream;

    public function __construct(Icescream $icescream){
        $this->icescream = $icescream;
    }

    public function CheBien(){
        $this->icescream->NauKem();
    }

    public function ThuongThuc(){
        $this->icescream->LiemKem();
    }
}