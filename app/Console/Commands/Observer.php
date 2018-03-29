<?php

namespace App\Console\Commands;

use App\Behavioral\Chef;
use App\Behavioral\Eater;
use Illuminate\Console\Command;

class Observer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:ob';

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
        $chef = new Chef();
        $eater = new Eater();

        $chef->attach($eater);
        $chef->cook("cookie");
        $eater->getMenu();
        $chef->cook("icescream");
        $eater->getMenu();
    }
}
