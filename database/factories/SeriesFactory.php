<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Series;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeriesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Series::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        Series::flushEventListeners();
        $title = $this->faker->realText(random_int(20, 60));
        $now = Carbon::now();
        
        return [
            'title' => $title,
            'slug' => Str::slug($title, '-', 'ar'),
            'body' => random_int(0, 1) ? $this->faker->text(300) : NULL,
            'user_id' => User::all()->random()->id,
            'status' => $this->faker->randomElement($array = array ('draft', 'published')),
            'created_at' => $now,
            'updated_at' => $now
        ];
    }
}
