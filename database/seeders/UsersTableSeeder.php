<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
              'id'  			=> strtoupper(md5("!@#!@#" . Carbon::now()->format('YmdH:i:s'))),
              'name'  			=> 'Admin',
              'email'		    => 'admin@gmail.com',
              'password'		=> bcrypt('password'),
              'role'            => 'admin',
              'is_verified'      => true,
              'avatar'          => null,
              'created_at'      => \Carbon\Carbon::now(),
              'updated_at'      => \Carbon\Carbon::now()
            ]
        ]);
    }
}
