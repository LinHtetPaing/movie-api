<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           "user_id" => User::find(fake()->numberBetween(1, 2))->id,
            "title"  => fake()->name(),
            "summary" => fake()->sentence(),
            "genres" => "Comedy",
            "author" => fake()->name(),
            "tags" => "movie",
            "imdb_rating" => fake()->numberBetween(1, 5),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
