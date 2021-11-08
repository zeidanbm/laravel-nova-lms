<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(QualitiesTableSeeder::class);
        $this->call(FormatsTableSeeder::class);
        $this->call(TypesTableSeeder::class);
        $this->call(IntervalsTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
    }
}
