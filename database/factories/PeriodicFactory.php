<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Cover;
use App\Models\Source;
use App\Models\Periodic;
use App\Models\Publisher;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeriodicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Periodic::class;
		
		/**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Periodic $periodic) {
						$publisher_ids = Publisher::all()->random(random_int(1, 3))->pluck('id');
						$source_ids = Source::all()->random(random_int(1, 3))->pluck('id');
						$pixel_url = 'http://lorempixel.com/g/';
						$img_id = random_int(0, 9);
						$new_cover = new Cover;
						$new_cover->url = $pixel_url . '600/900/abstract/' . $img_id;
						$new_cover->details = [
							'thumbnail' => $pixel_url . '140/210/abstract/' . $img_id,
							'medium' => $pixel_url . '210/315/abstract/' . $img_id,
							'large' => $pixel_url . '420/630/abstract/' . $img_id
						];
						
						$periodic->publishers()->attach($publisher_ids);
						$periodic->sources()->detach($source_ids);
						$periodic->cover()->save($new_cover);
        });
		}
		
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
			Periodic::flushEventListeners();
			
			$user_id = User::all()->random()->id;
			
			$has_bio = random_int(0, 1);
			$has_city = random_int(0, 1);
			$no_source = 0;
			$no_acquisition_year = 0;
			$no_issn = 0;
			$no_publisher = 0;
			$no_publishing_location = (bool) !!$has_city;
			$title = $this->faker->realText(random_int(20, 60));
			$now = Carbon::now();
			
			return [
				'title' => $title,
				'slug' => Str::slug($title, '-', 'ar'),
				'body' => $has_bio ? $this->faker->paragraph() : NULL,
				'acquisition_year'=> $this->faker->year($max = 'now'),
				'type_id' => 8, // magazine
				'interval_id' => $this->faker->randomElement(array (1,2,3,4,5,6,7)),
				'format_id' => $this->faker->randomElement(array (1,2,3)),
				'issn' => $no_issn ? NULL : $this->faker->isbn10,
				'language_id' => $this->faker->randomElement(array (1,2,3,4)),
				'shelf_code' => $this->faker->ean8,
				'publishing_location' => $has_city ? $this->faker->city : NULL,
				'details' => json_encode([
					'no_source' => $no_source,
					'no_acquisition_year' => $no_acquisition_year,
					'no_issn' => $no_issn,
					'no_publisher' => $no_publisher,
					'no_publishing_location' => $no_publishing_location
				]),
				'is_chosen' => random_int(0, 1),
				'is_owned' => random_int(0, 1),
				'user_id' => $user_id,
				'status' => $this->faker->randomElement(array ('draft', 'published')),
				'created_at' => $now,
				'updated_at' => $now
			];
		}
}