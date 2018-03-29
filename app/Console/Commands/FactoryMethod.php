<?php

namespace App\Console\Commands;

use App\Creational\FactoryMethod\Chef;
use Illuminate\Console\Command;

class FactoryMethod extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:fm';

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
        $chef = Chef::chooseCookieChef();
        $chef->makeFood();
        $chef = Chef::chooseIceChef();
        $chef->makeFood();
        //tocdetector
    }
}
