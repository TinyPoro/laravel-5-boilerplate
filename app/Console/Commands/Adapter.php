<?php

namespace App\Console\Commands;

use App\Structural\IceAdapter;
use App\Structural\IceObj;
use Illuminate\Console\Command;

class Adapter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:ad';

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
        $icescream = new IceObj();
        $adapter = new IceAdapter($icescream);

        $adapter->CheBien();
        $adapter->ThuongThuc();
        //crawler.php -> el()
    }
}
