<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(50)->create();

        for($i = 0; $i< 50; $i++){
            DB::table('user_details')->insert([
                'id' => $i+1,
                'user_id' => $i+1,
                'gender' => 'male',
                'age' => '25',
                'contact' => rand(7162100000, 9962113343),
                'city'=>'mohali',
                'state'=>'punjab',
                'country'=>'india',
                'qualification'=>'BA',
                'university'=>'PU',
                'created_at'=>date('Y-m-d H:i:s', rand(1662100000, 1662113343)),
            ]);
        }
    }
}
