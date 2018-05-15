<?php
/**
 * Created by PhpStorm.
 * User: tinyporo
 * Date: 15/05/2018
 * Time: 09:41
 */

namespace Poro\Algorithm;


class MorrisPratt extends AlgorithmAbstract
{
    const MORRIS_PRATT = 1;
    const KNUTH_MORRIS_PRATT = 0;

    private $f;

    private function preRun(){
        $i = 0;

        $j = $f[0] = -1;

        $m = strlen($this->search);

        while($i < $m-1){
            while($j > -1 && $this->search[$j] != $this->search[$i]){
                $j = $f[$j];
            }

            $f[++$i] = ++$j;
        }

        $this->f = $f;
    }

    private function betterPreRun(){
        $i = 0;

        $j = $f[0] = -1;

        $m = strlen($this->search);

        while($i < $m-1){
            while($j > -1 && $this->search[$j] != $this->search[$i]){
                $j = $f[$j];
            }

            $i++;
            $j++;

            if($this->search[$j] == $this->search[$i]) $f[$i] = $f[$j];
            else $f[$i] = $j;
        }

        $this->f = $f;
    }

    //mode = 0 :knuth-morris-pratt, mode = 1: morris=pratt
    public function run($mode = 0){
        if($mode == self::KNUTH_MORRIS_PRATT) $this->betterPreRun();
        else $this->preRun();

        $time_start = microtime(true);

        $result = [];

        $ALen = strlen($this->input);
        $BLen = strlen($this->search);

        $j = 0;
        $shift = 0;

        while($j <= $ALen - $BLen){
            $i = $shift;

            while($i < $BLen && $this->input[$j + $i] == $this->search[$i]){
                $i++;
            }

            if($i == $BLen) {
                $result[] = $j;

                $shift = 0;
                $j++;
            }
            else {
                if($i == $shift){
                    $shift = 0;
                    $j++;
                }else{
                    $shift = $this->f[$i];
                    $j = $j + $i - $shift;
                }
            }

        }

        $time_end = microtime(true);

        $this->setTime(($time_end-$time_start)*1000000);
        $this->setResult($result);
    }
}