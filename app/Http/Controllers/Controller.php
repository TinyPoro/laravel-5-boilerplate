<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Handle_String\Handle_String;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Poro\Algorithm\StringSearching\BruteForce;
use Poro\Algorithm\StringSearching\MorrisPratt;
use Poro\Algorithm\StringSearching\NumberMatching;
use Poro\Algorithm\StringSearching\RabinKarp;


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

        $len = strlen($search);

        $return = [];

        $brute_force = new BruteForce($data);
        $brute_force->run($search);
        $handle = new Handle_String($brute_force->getResult(), $data, $len);

        $return['brute_force'] = [
            'time' => $brute_force->getTime() . " ( μs)",
            'html' => $handle->ShowString(),
            'data' => $brute_force->getResult()
        ];


        $morris_pratt = new MorrisPratt($data);
        $morris_pratt->run($search, MorrisPratt::MORRIS_PRATT);
        $handle = new Handle_String($morris_pratt->getResult(), $data, $len);

        $return['morris_pratt'] = [
            'time' => $morris_pratt->getTime() . " ( μs)",
            'html' => $handle->ShowString(),
            'data' => $morris_pratt->getResult()
        ];

        $morris_pratt->run($search, MorrisPratt::KNUTH_MORRIS_PRATT);
        $handle = new Handle_String($morris_pratt->getResult(), $data, $len);

        $return['knuth_morris_pratt'] = [
            'time' => $morris_pratt->getTime() . " ( μs)",
            'html' => $handle->ShowString(),
            'data' => $morris_pratt->getResult()
        ];

        $number_matching = new NumberMatching($data);
        $number_matching->run($search);
        $handle = new Handle_String($number_matching->getResult(), $data, $len);

        $return['number_matching'] = [
            'time' => $number_matching->getTime() . " ( μs)",
            'html' => $handle->ShowString(),
            'data' => $number_matching->getResult()
        ];


        $rabin_karp = new RabinKarp($data);
        $rabin_karp->run($search);
        $handle = new Handle_String($rabin_karp->getResult(), $data, $len);

        $return['rabin_karp'] = [
            'time' => $rabin_karp->getTime() . " ( μs)",
            'html' => $handle->ShowString(),
            'data' => $rabin_karp->getResult()
        ];

        return $return;
    }

}
