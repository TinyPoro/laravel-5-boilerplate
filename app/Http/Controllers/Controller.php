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

    public function run(Request $request){
        $data = $request->get('input');
        $search = $request->get('search');

        $return = [];

        $time_start = microtime(true);
        $result = $this->BruteForce($data, $search);
        $time_end = microtime(true);

        $return['normal'] = [
            'time' => $time_end - $time_start,
            'data' => $result
        ];

        $time_start = microtime(true);
        $result = $this->RabinKarp($data, $search);
        $time_end = microtime(true);

        $return['rabin_karp'] = [
            'time' => $time_end - $time_start,
            'data' => $result
        ];

        return $return;
    }

    public function BruteForce($data, $search){
        $result = [];

        $sigA = 0;    //data
        $sigB = 0;    //search

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

    public function RabinKarp($data, $search){
        $result = [];

        $q = 3;

        $sigA = 0;    //data
        $sigB = 0;    //search

        $ALen = strlen($data);
        $BLen = strlen($search);

        $alpha = pow(10, $BLen-1) % $q;

        for ($i = 0; $i < $BLen; $i++) {
            $sigA = (($sigA * 10) % $q + $this->toNumber($data[$i])) % $q;
            $sigB = (($sigB * 10) % $q + $this->toNumber($search[$i])) % $q;
        }

        for($j = 0; $j <= $ALen - $BLen; $j++){
            if($sigA == $sigB) {
                $data_string = substr($data, $j, $BLen);

                if($data_string === $search) $result[] = $j;
            }

            if($j == $ALen - $BLen) break;

            $sigA = ((10 * ($sigA - ($alpha * $this->toNumber($data[$j])) % $q) % $q) % $q + $this->toNumber($data[$j+$BLen])) % $q;
        }


        return $result;
    }

    public function toNumber($char){
        if($char){
            return ord($char)-48;
        }

        return 0;
    }
}
