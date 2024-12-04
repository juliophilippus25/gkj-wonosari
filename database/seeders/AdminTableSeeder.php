<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ProfilAdmin;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = strtoupper(md5("!@#!@#" . Carbon::now()->format('YmdH:i:s')));

        User::insert([
            [
              'id'              => $userId,
              'email'           => 'admin@gmail.com',
              'password'        => bcrypt('password'),
              'role'            => 'admin',
              'is_verified'     => true,
              'created_at'      => Carbon::now(),
              'updated_at'      => Carbon::now()
            ]
        ]);

        ProfilAdmin::insert([
            [
              'user_id'         => $userId,
              'nama'            => 'Admin',
              'created_at'      => Carbon::now(),
              'updated_at'      => Carbon::now()
            ]
        ]);
    }
}
