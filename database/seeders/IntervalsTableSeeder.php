<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IntervalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'Monthly'
            ],
            [
                'id' => 2,
                'name' => 'Bi-Monthly'
            ],
            [
                'id' => 3,
                'name' => 'Seasonal'
            ],
            [
                'id' => 4,
                'name' => 'Half-Yearly'
            ],
            [
                'id' => 5,
                'name' => 'Yearly'
            ],
            [
                'id' => 6,
                'name' => 'Weekly'
            ],
            [
                'id' => 7,
                'name' => 'Half-Monthly'
            ]
        ];

        DB::table('intervals')->insert($data);
    }
}
