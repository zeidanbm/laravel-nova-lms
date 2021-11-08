<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Cover;
use App\Models\Periodic;
use App\Models\Publication;
use Illuminate\Database\Eloquent\Factories\Factory;

class PublicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
		protected $model = Publication::class;
		
		/**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Publication $publication) {
						$pixel_url = 'http://lorempixel.com/g/';
						$img_id = random_int(0, 9);
						$new_cover = new Cover;
						$new_cover->url = $pixel_url . '600/900/abstract/' . $img_id;
						$new_cover->details = [
							'thumbnail' => $pixel_url . '140/210/abstract/' . $img_id,
							'medium' => $pixel_url . '210/315/abstract/' . $img_id,
							'large' => $pixel_url . '420/630/abstract/' . $img_id
						];
						
						$publication->cover()->save($new_cover);
        });
		}
		
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
			Publication::flushEventListeners();
			
			$periodic_id = Periodic::all()->random()->id;
			$user_id = User::all()->random()->id;
			
			$has_volume = random_int(0, 30);
			$from = random_int(1, 10);
			$to = $from + random_int(1, 10);
			$form_date = Carbon::now()->subMonth(rand(12, 50));
			$now = Carbon::now();
	
			return [
				'periodic_id' => $periodic_id,
				'volume' => $has_volume ? $has_volume : NULL,
				'from'=> $from,
				'to' => $to,
				'from_date' => $form_date,
				'to_date' => $form_date->addMonth(rand(1, 12)),
				'quality_id' => $this->faker->randomElement(array (1,2,3,4)),
				'user_id' => $user_id,
				'status' => $this->faker->randomElement(array ('draft', 'published')),
				'created_at' => $now,
				'updated_at' => $now
			];
		}
}