<?php

namespace Database\Factories;

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
           "user_id" => fake()->numberBetween(1, 99),
            "title"  => fake()->title(),
            "summary" => fake()->sentence(),
            "genres" => "Comedy",
            "author" => fake()->name(),
            "tags" => "movie",
            "imdb_rating" => "3.5",
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
