<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Spatie\Permission\Models\Role::create(['name'=>'superadmin']);
        \Spatie\Permission\Models\Role::create(['name'=>'company']);
    	\Spatie\Permission\Models\Role::create(['name'=>'employee']);
    }
}
