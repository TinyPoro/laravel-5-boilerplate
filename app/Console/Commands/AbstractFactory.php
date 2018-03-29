<?php

namespace App\Console\Commands;

use App\Creational\AbstractFactory\Chef;
use Illuminate\Console\Command;

class AbstractFactory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:af';

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
        $chef = Chef::chooseChef(1);
        $chef->makeFood();
        $chef->makeDrink();
        $chef = Chef::chooseChef(2);
        $chef->makeFood();
        $chef->makeDrink();
    }
}
