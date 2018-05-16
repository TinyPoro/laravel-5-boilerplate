<?php
/**
 * Created by PhpStorm.
 * User: tinyporo
 * Date: 15/05/2018
 * Time: 10:05
 */

namespace Poro\Algorithm\StringSearching;


class NumberMatching extends AlgorithmAbstract
{
    public function run($search){
        $time_start = microtime(true);

        $result = [];

        $sigA = 0;    //data
        $sigB = 0;    //search

        $ALen = strlen($this->input);
        $BLen = strlen($search);

        $d = 223;

        $alpha = pow($d, $BLen-1);

        for ($i = 0; $i < $BLen; $i++) {
            $sigA = $sigA * $d + $this->toNumber($this->input[$i]);
            $sigB = $sigB * $d + $this->toNumber($search[$i]);
        }

        for($j = 0; $j <= $ALen - $BLen; $j++){
            if($sigA == $sigB) $result[] = $j;

            if($j == $ALen - $BLen) break;

            $sigA = $d * ($sigA - $alpha * $this->toNumber($this->input[$j])) + $this->toNumber($this->input[$j+$BLen]);
        }

        $time_end = microtime(true);

        $this->setTime(($time_end-$time_start)*1000000);
        $this->setResult($result);
    }
}