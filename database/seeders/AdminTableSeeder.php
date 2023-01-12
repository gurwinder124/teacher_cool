<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'id' => 1,
            'name' => 'Super Admin',
            'email' => 'superadmin@email.com',
            'password' => Hash::make('mind@123'),
            'role' => 0,
            'is_active'=>1,
            'created_at'=>date('Y-m-d H:i:s', rand(1662100000, 1662113343)),
        ]);

        DB::table('user_details')->insert([
            'id' => 1,
            'user_id' => 1,
            'gender' => 'male',
            'age' => '25',
            'contact' => 111222233344,
            'city'=>'mohali',
            'state'=>'punjab',
            'country'=>'india',
            'qualification'=>'BA',
            'university'=>'PU',
            'created_at'=>date('Y-m-d H:i:s', rand(1662100000, 1662113343)),
        ]);
        DB::table('user_details')->insert([
            'id' => 2,
            'user_id' => 2,
            'gender' => 'male',
            'age' => '25',
            'contact' => 112233344,
            'city'=>'Chandigarh',
            'state'=>'punjab',
            'country'=>'india',
            'qualification'=>'MA',
            'university'=>'CU',
            'created_at'=>date('Y-m-d H:i:s', rand(1662100000, 1662113343)),
        ]);
    }
}
