<?php

use App\Role;
use App\Admin;
use Illuminate\Database\Seeder;

class AdminRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin= Admin::first();       
		$admin->assignRole('developer');
    }
}
