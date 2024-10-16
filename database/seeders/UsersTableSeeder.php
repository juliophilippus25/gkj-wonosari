<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::insert([
            [
              'id'  			=> '1',
              'name'  			=> 'Admin',
              'email'		    => 'admin@admin.com',
              'password'		=> bcrypt('password'),
              'role'            => 'admin',
              'isVerified'      => true,
              'avatar'          => null,
              'created_at'      => \Carbon\Carbon::now(),
              'updated_at'      => \Carbon\Carbon::now()
            ]
        ]);
    }
}
