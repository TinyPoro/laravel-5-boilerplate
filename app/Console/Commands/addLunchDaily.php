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
        $now = Carbon::now();
        if($now->format('l') == 'Friday') $tomorrow = $now->addDay(3);
        else if($now->format('l') == 'Sunday') return;
        else $tomorrow = $now->addDay(1);

        $tomorrow_string = date_format($tomorrow, 'Y-m-d');

        $client = new Client();

        DB::table('addLunch')->where('date', $tomorrow_string)->orderBy('id')
            ->chunk(10, function($datas) use($client){
                foreach($datas as $data){
                    $id = $data->id;
                    $name = $data->name;
                    $pass = DB::table('users')->where('name', $name)->first()->password;
                    $date = $data->date;

                    $data = '[{ "type":"visit",
                  "url":"https://erp.nhanh.vn/hrm/lunch/add"},
                  { "type":"input",
                  "selector":"#username",
                    "value":"'.$name.'"
                  },
                  { "type":"input",
                  "selector":"#password",
                    "value":"'.$pass.'"
                  },
                  { "type":"submit",
                  "selector":"#btnSignin",
                    "action":"click"
                  },
                { "type":"reload",
                  "url":"https://erp.nhanh.vn/hrm/lunch/add"},
                  { "type":"submit",
                  "selector":"[data-date=\''.$date.'\']",
                    "action":"click"
                  },
                  { "type":"submit",
                  "selector":"#btnSaveCrmContact",
                    "action":"click"
                  }
                ]
                 ';

                    $response = $client->request(
                        'POST',
                        'http://127.0.0.1:8080/',
                        [
                            'form_params' => [
                                'script' => $data
                            ]
                        ]
                    );

                    $res = $response->getBody()->getContents();

                    if($res == 'ok') {
                        $cur_status = DB::table('addLunch')->find($id)->status;
                        if($cur_status == 0) $new_status = 1;
                        else $new_status = 0;

                        DB::table('addLunch')->where('id', $id)
                            ->update(['status' => $new_status]);
                    }
                }
            });
    }
}