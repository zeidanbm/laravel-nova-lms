<?php

namespace Database\Seeders\Demo;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubtopicTableSeeder extends Seeder
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
				'id' => 1028,
				'name' => 'الديانات القديمة',
				'topic_id' => 579,
			],
			[
				'id' => 1077,
				'name' => 'المذاهب و الفرق',
				'topic_id' => 579,
			],
			[
				'id' => 1133,
				'name' => 'الديانة المسيحية',
				'topic_id' => 579,
			],
			[
				'id' => 3635,
				'name' => 'الديانة اليهودية',
				'topic_id' => 579,
			],
			[
				'id' => 3636,
				'name' => 'النقد و مقارنة الاديان',
				'topic_id' => 579
			],
			[
				'id' => 2508,
				'name' => 'التراجم و السير',
				'topic_id' => 577,
			],
			[
				'id' => 2293,
				'name' => 'المذكرات',
				'topic_id' => 577,
			],
			[
				'id' => 2509,
				'name' => 'الانساب',
				'topic_id' => 577,
			],
			[
				'id' => 2362,
				'name' => 'المال',
				'topic_id' => 861
			],
			[
				'id' => 2363,
				'name' => 'الاقتصاد',
				'topic_id' => 861
			],
			[
				'id' => 13232,
				'name' => 'المحاسبة',
				'topic_id' => 861
			],
			[
				'id' => 13233,
				'name' => 'ادارة الاعمال',
				'topic_id' => 861
			],
			[
				'id' => 1306,
				'name' => 'الاستخبارات',
				'topic_id' => 575
			],
			[
				'id' => 1635,
				'name' => 'السياسات الدولية',
				'topic_id' => 575
			],
			[
				'id' => 1636,
				'name' => 'السياسة و نظام الحكم',
				'topic_id' => 575
			],
			[
				'id' => 10148,
				'name' => 'القوانين و التشريعات',
				'topic_id' => 575
			],
			[
				'id' => 2417,
				'name' => 'الرواية',
				'topic_id' => 573
			],
			[
				'id' => 2480,
				'name' => 'الشعر',
				'topic_id' => 573
			],
			[
				'id' => 2588,
				'name' => 'القصص',
				'topic_id' => 573
			],
			[
				'id' => 10954,
				'name' => 'الادب',
				'topic_id' => 573
			],
			[
				'id' => 13890,
				'name' => 'اللغة',
				'topic_id' => 573
			],
			[
				'id' => 3116,
				'name' => 'معجم اللغات',
				'topic_id' => 862
			],
			[
				'id' => 3146,
				'name' => 'معجم التاريخ و الجغرافية',
				'topic_id' => 862
			],
			[
				'id' => 3676,
				'name' => 'الدليل و الفهرس',
				'topic_id' => 862
			],
			[
				'id' => 2470,
				'name' => 'القران وعلومه',
				'topic_id' => 580
			],
			[
				'id' => 3637,
				'name' => 'الحديث و علومه',
				'topic_id' => 580
			],
			[
				'id' => 4598,
				'name' => 'مكتبة اهل البيت',
				'topic_id' => 580
			],
			[
				'id' => 3638,
				'name' => 'الفقه و اصوله',
				'topic_id' => 580
			],
			[
				'id' => 6367,
				'name' => 'اصول الدين و علم الكلام',
				'topic_id' => 580
			],
			[
				'id' => 6368,
				'name' => 'الشيعة و التشيع',
				'topic_id' => 580
			],
			[
				'id' => 6369,
				'name' => 'الاسلاميات',
				'topic_id' => 580
			],
			[
				'id' => 6370,
				'name' => 'المسائل الخلافية',
				'topic_id' => 580
			],
			[
				'id' => 6372,
				'name' => 'اللطائف و الاخلاق',
				'topic_id' => 580
			],
			[
				'id' => 865,
				'name' => 'التاريخ السياسي',
				'topic_id' => 567
			],
			[
				'id' => 866,
				'name' => 'التاريخ الاجتماعي',
				'topic_id' => 567
			],
			[
				'id' => 867,
				'name' => 'التاريخ القديم',
				'topic_id' => 567
			],
			[
				'id' => 871,
				'name' => 'التأريخ',
				'topic_id' => 567
			],
			[
				'id' => 930,
				'name' => 'التاريخ الاقتصادي',
				'topic_id' => 567
			],
			[
				'id' => 863,
				'name' => 'التاريخ الاسلامي',
				'topic_id' => 567
			],
			[
				'id' => 1775,
				'name' => 'علم الاجتماع',
				'topic_id' => 570
			],
			[
				'id' => 1776,
				'name' => 'التربية و التعليم',
				'topic_id' => 570
			],
			[
				'id' => 3062,
				'name' => 'علم النفس',
				'topic_id' => 570
			],
			[
				'id' => 1071,
				'name' => 'الفلسفة الاسلامية',
				'topic_id' => 572
			],
			[
				'id' => 2505,
				'name' => 'الفلسفة الغربية',
				'topic_id' => 572
			],
			[
				'id' => 2506,
				'name' => 'الفلسفة العربية',
				'topic_id' => 572
			],
			[
				'id' => 6608,
				'name' => 'الفكر المعاصر',
				'topic_id' => 572
			],
			[
				'id' => 6609,
				'name' => 'الفكر الاسلامي',
				'topic_id' => 572
			],
			[
				'id' => 12429,
				'name' => 'الفلسفة الحديثة',
				'topic_id' => 572
			],
			[
				'id' => 2426,
				'name' => 'الندوات و المؤتمرات',
				'topic_id' => 574
			],
			[
				'id' => 3607,
				'name' => 'الصحافه',
				'topic_id' => 574
			],
			[
				'id' => 3675,
				'name' => 'الفنون',
				'topic_id' => 574
			],
			[
				'id' => 9780,
				'name' => 'المتفرقات',
				'topic_id' => 574
			],
			[
				'id' => 13945,
				'name' => 'الابحاث و الدراسات',
				'topic_id' => 574
			]
		];
		
		DB::table('subtopics')->insert($data);
	}
}