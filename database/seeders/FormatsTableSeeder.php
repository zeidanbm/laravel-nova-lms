<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormatsTableSeeder extends Seeder
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
                'name' => 'Electronic'
            ],
            [
                'id' => 2,
                'name' => 'Digital'
            ],
            [
                'id' => 3,
                'name' => 'Paper'
            ]
        ];

        DB::table('formats')->insert($data);
    }
}
