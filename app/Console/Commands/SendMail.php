<?php

namespace App\Console\Commands;

use App\Mail\LunchError;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:mail';

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

        $builder = DB::table('addLunch')->where('date', $tomorrow_string)
            ->where('status', 0)->orderBy('id');

        if($builder->count() == 0){
            $mail = new LunchError($tomorrow_string);
            Mail::to('ngophuongtuan@gmail.com')->queue($mail);
            Mail::to('huyitptit2015@gmail.com')->queue($mail);
        }
        else{
            $builder->chunk(10, function($datas){
                foreach($datas as $data){
                    $name = $data->name;
                    $date = $data->date;
                    $email = DB::table('users')->where('name', $name)->first()->email;

                    if($email != NULL){
                        try{
                            $mail = new LunchError($date, $name);
                            Mail::to('ngophuongtuan@gmail.com')->queue($mail);
                            Mail::to($email)->queue($mail);
                        }catch (\Exception $e){
                            dump($e->getMessage());
                        }
                    }

                }
            });
        }
    }
}
