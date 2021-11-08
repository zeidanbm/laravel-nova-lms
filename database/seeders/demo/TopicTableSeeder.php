<?php

namespace Database\Seeders\Demo;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopicTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('topics')->insert([
			[
				'id' => 579,
				'name' => 'الاديان والمذاهب',
			],
			[
				'id' => 577,
				'name' => 'الاعلام والتراجم',
			],
			[
				'id' => 861,
				'name' => 'الاقتصاد و المال',
			],
			[
				'id' => 575,
				'name' => 'السياسة و القانون',
			],
			[
				'id' => 573,
				'name' => 'اللغة و الادب',
			],
			[
				'id' => 862,
				'name' => 'المعاجم',
			],
			[
				'id' => 580,
				'name' => 'المكتبة الاسلامية',
			],
			[
				'id' => 567,
				'name' => 'التاريخ',
			],
			[
				'id' => 570,
				'name' => 'العلوم الاجتماعية ',
			],
			[
				'id' => 572,
				'name' => 'الفكر و الفلسفة',
			],
			[
				'id' => 574,
				'name' => 'المواضيع المتنوعة',
			]
		]);
	}
}