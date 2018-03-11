<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class CreatePermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:per';

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
//        Permission::create(['name' => 'manage_news']);
//        Permission::create(['name' => 'manage_users']);
        Permission::create(['name' => 'manage_category']);

//        // Adding permissions to a user
//        $user->givePermissionTo('edit articles');
//
//        // Adding permissions via a role
//        $user->assignRole('writer');
//
//        $role->givePermissionTo('edit articles');
    }
}
