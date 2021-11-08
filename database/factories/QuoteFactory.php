<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Quote;
use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Quote::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        Quote::flushEventListeners();
        $now = Carbon::now();
        
        return [
            'body' => $this->faker->realText(125),
            'author_id' => Author::all()->random()->id,
            'user_id' => User::all()->random()->id,
            'status' => $this->faker->randomElement($array = array ('draft', 'published')),
            'created_at' => $now,
            'updated_at' => $now
        ];
    }
}
