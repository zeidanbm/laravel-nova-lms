<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QualitiesTableSeeder extends Seeder
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
                'name' => 'Great'
            ],
            [
                'id' => 2,
                'name' => 'Good'
            ],
            [
                'id' => 3,
                'name' => 'Fair'
            ],
            [
                'id' => 4,
                'name' => 'Bad'
            ]
        ];

        DB::table('qualities')->insert($data);
    }
}
