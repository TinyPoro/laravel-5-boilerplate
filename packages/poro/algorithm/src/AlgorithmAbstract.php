<?php
/**
 * Created by PhpStorm.
 * User: tinyporo
 * Date: 15/05/2018
 * Time: 09:14
 */

namespace Poro\Algorithm;


abstract class AlgorithmAbstract implements AlgorithmInterface
{
    protected $input;
    protected $search;

    private $result;
    private $time;

    public function __construct($input, $search){
        $this->input = $input;
        $this->search = $search;
    }

    public function setResult($result){
        $this->result = $result;
    }

    public function getResult(){
        return $this->result;
    }

    public function setTime($time){
        $this->time = $time;
    }

    public function getTime(){
        return $this->time;
    }

    public function toNumber($char){
        if($char){
            return ord($char)-32;
        }

        return 0;
    }
}