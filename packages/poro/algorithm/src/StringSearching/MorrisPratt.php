<?php
/**
 * Created by PhpStorm.
 * User: tinyporo
 * Date: 15/05/2018
 * Time: 09:41
 */

namespace Poro\Algorithm\StringSearching;


class MorrisPratt extends AlgorithmAbstract
{
    const MORRIS_PRATT = 1;
    const KNUTH_MORRIS_PRATT = 0;

    private $f;

    private function preRun($search){
        $i = 0;

        $j = $f[0] = -1;

        $m = strlen($search);

        while($i < $m-1){
            while($j > -1 && $search[$j] != $search[$i]){
                $j = $f[$j];
            }

            $f[++$i] = ++$j;
        }

        $this->f = $f;
    }

    private function betterPreRun($search){
        $i = 0;

        $j = $f[0] = -1;

        $m = strlen($search);

        while($i < $m-1){
            while($j > -1 && $search[$j] != $search[$i]){
                $j = $f[$j];
            }

            $i++;
            $j++;

            if($search[$j] == $search[$i]) $f[$i] = $f[$j];
            else $f[$i] = $j;
        }

        $this->f = $f;
    }

    //mode = 0 :knuth-morris-pratt, mode = 1: morris=pratt
    public function run($search, $mode = 0){
        if($mode == self::KNUTH_MORRIS_PRATT) $this->betterPreRun($search);
        else $this->preRun($search);

        $time_start = microtime(true);

        $result = [];

        $ALen = strlen($this->input);
        $BLen = strlen($search);

        $j = 0;
        $shift = 0;

        while($j <= $ALen - $BLen){
            $i = $shift;

            while($i < $BLen && $this->input[$j + $i] == $search[$i]){
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