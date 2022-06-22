<?php

use App\Role;
use App\Permission;
use Illuminate\Database\Seeder;

class RolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$permission = Permission::first();
		$role       = Role::first();
		$role->givePermissionTo($permission);
    }
}
