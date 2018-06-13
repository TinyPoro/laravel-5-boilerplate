<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Poro\PdfToRt\PdfToRt;

class testrt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'a:a';

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
        $a = new PdfToRt('/var/www/laravel-5-boilerplate/1.pdf');
        dd($a->run());
    }
}
