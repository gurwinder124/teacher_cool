<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subscriptions')->insert(
            [
            'id' => 1,
            'name' => 'Platinum',
            'slug' => 'platinum',
            'is_platinum' => 1,
            'created_at'=>date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'name' => 'Gold',
                'slug' => 'gold',
                'is_platinum' => 0,
                'created_at'=>date('Y-m-d H:i:s'),
            ]
        );
    }
}
