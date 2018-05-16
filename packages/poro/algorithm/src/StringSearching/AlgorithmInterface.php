<?php
/**
 * Created by PhpStorm.
 * User: tinyporo
 * Date: 15/05/2018
 * Time: 09:13
 */

namespace Poro\Algorithm\StringSearching;


interface AlgorithmInterface
{
    public function run($search);
    public function setResult($result);
    public function getResult();
    public function setTime($time);
    public function getTime();
    public function toNumber($char);
}