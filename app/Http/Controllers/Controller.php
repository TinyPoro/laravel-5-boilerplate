<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Poro\Algorithm\BruteForce;
use Poro\Algorithm\MorrisPratt;
use Poro\Algorithm\NumberMatching;
use Poro\Algorithm\RabinKarp;


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

        $brute_force = new BruteForce($data, $search);
        $brute_force->run();

        $return['brute_force'] = [
            'time' => $brute_force->getTime() . " ( μs)",
            'data' => $brute_force->getResult()
        ];


        $morris_pratt = new MorrisPratt($data, $search);
        $morris_pratt->run(MorrisPratt::MORRIS_PRATT);

        $return['morris_pratt'] = [
            'time' => $morris_pratt->getTime() . " ( μs)",
            'data' => $morris_pratt->getResult()
        ];

        $morris_pratt->run(MorrisPratt::KNUTH_MORRIS_PRATT);

        $return['knuth_morris_pratt'] = [
            'time' => $morris_pratt->getTime() . " ( μs)",
            'data' => $morris_pratt->getResult()
        ];

        $number_matching = new NumberMatching($data, $search);
        $number_matching->run();

        $return['number_matching'] = [
            'time' => $number_matching->getTime() . " ( μs)",
            'data' => $number_matching->getResult()
        ];


        $rabin_karp = new RabinKarp($data, $search);
        $rabin_karp->run();

        $return['rabin_karp'] = [
            'time' => $rabin_karp->getTime() . " ( μs)",
            'data' => $rabin_karp->getResult()
        ];

        return $return;
    }

}
