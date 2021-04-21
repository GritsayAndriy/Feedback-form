<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manageUser = new Permission();
        $manageUser->name = 'View request';
        $manageUser->slug = 'view-request';
        $manageUser->save();

        $createTasks = new Permission();
        $createTasks->name = 'Send feedback';
        $createTasks->slug = 'send-feedback';
        $createTasks->save();
    }
}
