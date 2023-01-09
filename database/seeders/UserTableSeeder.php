<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Test User',
            'email' => 'user@email.com',
            'password' => Hash::make('mind@123'),
            'created_at'=>date('Y-m-d H:i:s', rand(1662100000, 1662113343)),
           
        ]);
    }
}
