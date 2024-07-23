<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SuperAdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=\App\Models\User::create([
            'name'=>'superadmin',
            'email'=>'superadmin@gmail.com',
            'password'=>bcrypt('123456'),
            'actual_password'=>'123456',
            'company_id'=>'1'
           ]);
           $user->assignRole('superadmin');
    }
}
