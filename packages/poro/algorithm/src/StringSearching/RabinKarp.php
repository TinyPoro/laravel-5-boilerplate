<?php
/**
 * Created by PhpStorm.
 * User: tinyporo
 * Date: 15/05/2018
 * Time: 10:09
 */

namespace Poro\Algorithm\StringSearching;


class RabinKarp extends AlgorithmAbstract
{
    public function run($search){
        $time_start = microtime(true);

        $result = [];

        $sigA = 0;    //data
        $sigB = 0;    //search

        $ALen = strlen($this->input);
        $BLen = strlen($search);

        $q = 101;
        $d = 10;
        $d = 223;

        $alpha = pow($d % $q, $BLen-1) % $q;

        for ($i = 0; $i < $BLen; $i++) {
            $sigA = (($sigA * $d) % $q + $this->toNumber($this->input[$i])) % $q;
            $sigB = (($sigB * $d) % $q + $this->toNumber($search[$i])) % $q;
        }

        for($j = 0; $j <= $ALen - $BLen; $j++){
            if($sigA == $sigB) {
                $data_string = substr($this->input, $j, $BLen);
                if($data_string == $search) $result[] = $j;
            }

            if($j == $ALen - $BLen) break;

            $sigA = (($d * ($sigA - $alpha * $this->toNumber($this->input[$j]) % $q) % $q) % $q + $this->toNumber($this->input[$j+$BLen])) % $q;
        }

        $time_end = microtime(true);

        $this->setTime(($time_end-$time_start)*1000000);
        $this->setResult($result);
    }

    public function makePrime($min, $max){
        do{
            $prime = rand($min, $max);
        }while(!$this->checkPrime($prime));

        return $prime;
    }

    public function checkPrime($number){
        if($number % 2 == 0){
            return false;
        }else{
            $i = 3;

            while($i <= sqrt($number)){
                if($number % $i == 0) return false;

                $i += 2;
            }
        }

        return true;
    }
}