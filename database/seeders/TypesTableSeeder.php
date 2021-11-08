<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypesTableSeeder extends Seeder
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
                'name' => 'Folder',
                'name_ar' => 'مجلد'
            ],
            [
                'id' => 2,
                'name' => 'Series',
                'name_ar' => 'سلسلة'
            ],
            [
                'id' => 3,
                'name' => 'Picture Book',
                'name_ar' => 'كتاب مصور‬'
            ],
            [
                'id' => 4,
                'name' => 'Manuscript',
                'name_ar' => 'مخطوطة'
            ],
            [
                'id' => 5,
                'name' => 'Book',
                'name_ar' => 'كتاب'
            ],
            [
                'id' => 6,
                'name' => 'Rare Book',
                'name_ar' => 'كتاب نادر'
            ],
            [
                'id' => 7,
                'name' => 'News Paper',
                'name_ar' => 'صحيفة'
            ],
            [
                'id' => 8,
                'name' => 'Magazine',
                'name_ar' => 'مجلة'
            ],
            [
                'id' => 9,
                'name' => 'Specialized Magazine',
                'name_ar' => 'مجلة متخصصة'
            ],
            [
                'id' => 10,
                'name' => 'Quote',
                'name_ar' => 'قول مأثور'
            ],
            [
                'id' => 11,
                'name' => 'Jabal Amel Figures',
                'name_ar' => 'رجالات جبل عامل'
            ]
        ];

        DB::table('types')->insert($data);
    }
}
