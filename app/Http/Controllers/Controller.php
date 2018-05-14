<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Class Controller.
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function show(){
        return view('algorithm');
    }

    public function computeBack($search){
        $i = 0;

        $j = $f[0] = -1;

        $m = strlen($search);

        while($i < $m-1){
            while($j > -1 && $search[$j] != $search[$i]){
                $j = $f[$j];
            }

            $f[++$i] = ++$j;
        }


        return $f;
    }

    public function computeBack1($search){
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


        return $f;
    }

    public function run(Request $request){
        $data = $request->get('input');
        $search = $request->get('search');

        $return = [];

        $time_start = microtime(true);
        $result = $this->BruteForce($data, $search);
        $time_end = microtime(true);
        $return['brute_force'] = [
            'time' => ($time_end - $time_start)*1000000 . " ( μs)",
            'data' => $result
        ];


        $f = $this->computeBack($search);

        $time_start = microtime(true);
        $result = $this->KnuthMorrisPratt($data, $search, $f);
        $time_end = microtime(true);

        $return['knuth_morris_pratt'] = [
            'time' => ($time_end - $time_start)*1000000 . " ( μs)",
            'data' => $result
        ];

        $time_start = microtime(true);
        $result = $this->NumberMatching($data, $search);
        $time_end = microtime(true);
        $return['number_matching'] = [
            'time' => ($time_end - $time_start)*1000000 . " ( μs)",
            'data' => $result
        ];


        $q = $this->makePrime(2, strlen($search)*strlen($search)*log(strlen($search)));
        $time_start = microtime(true);
        $result = $this->RabinKarp($data, $search, $q);
        $time_end = microtime(true);
        $return['rabin_karp'] = [
            'time' => ($time_end - $time_start)*1000000 . " ( μs)",
            'data' => $result
        ];

        return $return;
    }

    public function BruteForce($data, $search){
        $result = [];

        $ALen = strlen($data);
        $BLen = strlen($search);

        for($j = 0; $j <= $ALen - $BLen; $j++){
            $i = 0;

            while($i < $BLen && $data[$j + $i] == $search[$i]){
                $i++;
            }

            if($i == $BLen) $result[] = $j;
        }


        return $result;
    }

    public function KnuthMorrisPratt($data, $search, $f){
        $result = [];

        $ALen = strlen($data);
        $BLen = strlen($search);

        $j = 0;
        $shift = 0;

        while($j <= $ALen - $BLen){
            $i = $shift;

            while($i < $BLen && $data[$j + $i] == $search[$i]){
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
                    $shift = $f[$i];
                    $j = $j + $i - $shift;
                }
            }

        }

        return $result;
    }


    public function NumberMatching($data, $search){
        $result = [];

        $sigA = 0;    //data
        $sigB = 0;    //search

        $ALen = strlen($data);
        $BLen = strlen($search);

        $alpha = pow(10, $BLen-1);

        for ($i = 0; $i < $BLen; $i++) {
            $sigA = $sigA * 10 + $this->toNumber($data[$i]);
            $sigB = $sigB * 10 + $this->toNumber($search[$i]);
        }

        for($j = 0; $j <= $ALen - $BLen; $j++){
            if($sigA == $sigB) $result[] = $j;

            if($j == $ALen - $BLen) break;

            $sigA = 10 * ($sigA - $alpha * $this->toNumber($data[$j])) + $this->toNumber($data[$j+$BLen]);
        }


        return $result;
    }

    public function RabinKarp($data, $search, $q){
        $result = [];

        $sigA = 0;    //data
        $sigB = 0;    //search

        $ALen = strlen($data);
        $BLen = strlen($search);

        $q = 101;
        $d = 10;
        $d = 223;

        $alpha = pow($d % $q, $BLen-1) ;

        for ($i = 0; $i < $BLen; $i++) {
            $sigA = (($sigA * $d) % $q + $this->toNumber($data[$i])) % $q;
            $sigB = (($sigB * $d) % $q + $this->toNumber($search[$i])) % $q;
        }

        dump("Root: ". pow($d, $BLen-1));

        for($j = 0; $j <= $ALen - $BLen; $j++){
            if($sigA == $sigB) {
                $data_string = substr($data, $j, $BLen);
                if($data_string === $search) $result[] = $j;
            }

            if($j == $ALen - $BLen) break;

            $sigA = (($d * ($sigA - ($alpha * $this->toNumber($data[$j])) % $q) % $q) % $q + $this->toNumber($data[$j+$BLen])) % $q;
        }


        return $result;
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

    public function toNumber($char){
        if($char){
            return ord($char)-32;
        }

        return 0;
    }
}
