<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesTableSeeder extends Seeder
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
                'name' => 'Arabic'
            ],
            [
                'id' => 2,
                'name' => 'English'
            ],
            [
                'id' => 3,
                'name' => 'French'
            ],
            [
                'id' => 4,
                'name' => 'Farsi'
            ]
        ];

        DB::table('languages')->insert($data);
    }
}
