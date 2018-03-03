<?php

namespace App\Console\Commands;

use App\Category;
use App\News;
use Illuminate\Console\Command;

class FakeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake:data';

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
        $new = new News();
        $new->user_id = 1;
        $new->title = "Fake Title";
        $new->content = "Fake Content!";
        $new->save();

        $new = new News();
        $new->user_id = 1;
        $new->title = "Fake Title";
        $new->content = "Fake Content!";
        $new->save();

        $new = new News();
        $new->user_id = 2;
        $new->title = "Fake Title";
        $new->content = "Fake Content!";
        $new->save();

        $new = new News();
        $new->user_id = 3;
        $new->title = "Fake Title";
        $new->content = "Fake Content!";
        $new->save();

        $category = new Category();
        $category->name = "Test Category 1";
        $category->save();

        $category = new Category();
        $category->name = "Test Category 2";
        $category->save();

        News::find(1)->categories()->attach(1);
        News::find(2)->categories()->attach(1);
        News::find(3)->categories()->attach(1);
        News::find(3)->categories()->attach(2);
        News::find(4)->categories()->attach(2);
    }
}
