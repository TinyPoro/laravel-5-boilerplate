<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImageChecker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'a:b';

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
        $path = '/home/tun/Pictures/1.jpeg';
        $image = new \Poro\Image_Checker\ImageChecker($path);
        dump($image->detectFormat());
        $path = 'http://www.codediesel.com/wp-content/uploads/2010/09/winhex.gif';
        $image = new \Poro\Image_Checker\ImageChecker($path);
        dump($image->detectFormat());
        $path = 'https://secure.gravatar.com/avatar/fa9df688ce1e6ff39052faa763e839ff?s=60&d=mm&r=g';
        $image = new \Poro\Image_Checker\ImageChecker($path);
        dump($image->detectFormat());
    }
}
