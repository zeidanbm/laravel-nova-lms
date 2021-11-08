<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now();
		$data = [
			[
				'id' => 1,
				'name' => 'Admin',
				'email' => 'admin@lms.test',
				'email_verified_at' => $now,
				'password' => bcrypt('123657')
			],
			[
				'id' => 4,
				'name' => 'doha',
				'email' => 'doha@lms.test',
				'email_verified_at' => $now,
				'password' => bcrypt('123456')
			],
			[
				'id' => 5,
				'name' => 'mona',
				'email' => 'mona@lms.test',
				'email_verified_at' => $now,
				'password' => bcrypt('123456')
			],
			[
				'id' => 6,
				'name' => 'nada',
				'email' => 'nada@lms.test',
				'email_verified_at' => $now,
				'password' => bcrypt('123456')
			],
			[
				'id' => 8,
				'name' => 'marwa',
				'email' => 'marwa@lms.test',
				'email_verified_at' => $now,
				'password' => bcrypt('123456')
			],
			[
				'id' => 9,
				'name' => 'sara',
				'email' => 'sara@lms.test',
				'email_verified_at' => $now,
				'password' => bcrypt('123456')
			],
			[
				'id' => 10,
				'name' => 'mehdi',
				'email' => 'mehdi@lms.test',
				'email_verified_at' => $now,
				'password' => bcrypt('123456')
			],
			[
				'id' => 11,
				'name' => 'nour',
				'email' => 'nour@lms.test',
				'email_verified_at' => $now,
				'password' => bcrypt('123456')
			]
		];

		DB::table('users')->insert($data);
		$this->setUserRoles();
	}
	
	private function setUserRoles()
	{
		DB::table('role_user')->insert([
			[
				'role_id' => 1,
				'user_id' => 1,
			],
			[
				'role_id' => 3,
				'user_id' => 4,
			],
			[
				'role_id' => 3,
				'user_id' => 5,
			],
			[
				'role_id' => 2,
				'user_id' => 6,
			],
			[
				'role_id' => 2,
				'user_id' => 8,
			],
			[
				'role_id' => 3,
				'user_id' => 9,
			],
			[
				'role_id' => 1,
				'user_id' => 10,
			],
			[
				'role_id' => 3,
				'user_id' => 11,
			]
		]);
	}
}
