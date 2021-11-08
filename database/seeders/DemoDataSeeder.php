<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Book;
use App\Models\Quote;
use App\Models\Author;
use App\Models\Series;
use App\Models\Source;
use App\Models\Periodic;
use App\Models\Publisher;
use App\Models\Publication;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Database\Seeders\Demo\TopicTableSeeder;
use Database\Seeders\Demo\SubtopicTableSeeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class DemoDataSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();
		
		$this->call(TopicTableSeeder::class);
		$this->call(SubtopicTableSeeder::class);
		
		Tag::factory()
				->times(100)
				->create();
		
		Author::factory()
					->times(100)
					->create();
					
		Source::factory()
					->times(100)
					->create();
		
		Publisher::factory()
						->times(100)
						->create();
						
		Quote::factory()
					->times(50)
					->create();
				
		Series::factory()
					->times(30)
					->has(
						Book::factory()
								->count(random_int(1, 20))
								->state(function (array $attributes, Series $series) {
										return [
											'series_id' => $series->id,
											'type_id' => 2
										];
								})
					)
					->create();
					
		Book::factory()
					->times(80)
					->create();
					
		Book::factory()
					->times(50)
					->folder()
					->create();
					
		Periodic::factory()
					->times(10)
					->has(
						Publication::factory()
								->count(random_int(1, 20))
								->state(function (array $attributes, Periodic $periodic) {
										return [
											'periodic_id' => $periodic->id
										];
								})
					)
					->create();

    Model::reguard();
  }
}
