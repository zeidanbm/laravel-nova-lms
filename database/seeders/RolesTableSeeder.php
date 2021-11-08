<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class RolesTableSeeder extends Seeder
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
								'name' => 'Admin',
								'slug' => 'admin'
            ],
            [
                'id' => 2,
								'name' => 'Editor',
								'slug' => 'editor'
            ],
            [
                'id' => 3,
								'name' => 'Writer',
								'slug' => 'writer'
            ]
        ];

				DB::table('roles')->insert($data);
				$this->addPermissions();
		}
		
		private function addPermissions()
		{
			$data = [];
			
			$admin_permissions = Config::get('nova-permissions.admin_permissions');
			foreach ($admin_permissions as $permission) {
				$data[] = [
					'role_id' => 1,
					'permission_slug' => $permission
				];
			}
			
			$editor_permissions = Config::get('nova-permissions.editor_permissions');
			foreach ($editor_permissions as $permission) {
				$data[] = [
					'role_id' => 2,
					'permission_slug' => $permission
				];
			}
			
			$writer_permissions = Config::get('nova-permissions.writer_permissions');
			foreach ($writer_permissions as $permission) {
				$data[] = [
					'role_id' => 3,
					'permission_slug' => $permission
				];
			}

			DB::table('role_permission')->insert($data);
		}
}
