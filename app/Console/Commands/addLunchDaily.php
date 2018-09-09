<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class addLunchDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:lunch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        date_default_timezone_set("Asia/Bangkok");
        $now = Carbon::now();

        $date_l = $now->format('l');
        if($date_l == 'Friday') $tomorrow = $now->addDay(3);
        else if($date_l == 'Sunday' || $date_l == 'Saturday') return;
        else $tomorrow = $now->addDay(1);

        $tomorrow_l = $tomorrow->format('l');

        $client = new Client(['cookies' => true]);

        DB::table('addLunch')->where('date', $tomorrow_l)->orderBy('id')
            ->chunk(10, function($datas) use($client, $tomorrow){
                foreach($datas as $data){
                    $id = $data->id;
                    $name = $data->name;
                    $pass = DB::table('users')->where('name', $name)->first()->password;
                    $date = date_format($tomorrow, 'Y-m-d');

                    $response = $client->request(
                        'POST',
                        'https://erp.nhanh.vn/user/signin',
                        [
                            'form_params' => [
                                'username' => 'tuannp',
                                'password' => 'tinyporo181',
                            ]
                        ]
                    );

                    $cookieJar = $client->getConfig('cookies');

                    if($cookieJar){
                        //applyDated
                        $response = $client->request(
                            'POST',
                            'https://erp.nhanh.vn/hrm/lunch/add',
                            [
                                'cookies' => $cookieJar,
                                'form_params' => [
                                    'bookDate' => [$date]
                                ]
                            ]
                        );

                    }else{
                        continue;
                    }

                    $res = json_decode($response->getBody()->getContents());

                    if(!is_null($res)) {
                        $cur_status = \DB::table('addLunch')->find($id)->status;
                        if($cur_status == 0) $new_status = 1;
                        else $new_status = 0;

                        \DB::table('addLunch')->where('id', $id)
                            ->update(['status' => $new_status]);
                    }
                }
            });
    }
}
