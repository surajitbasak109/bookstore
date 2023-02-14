<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->title(),
            'author_id' => 2,
            'genre_id' => 3,
            'description' => fake()->paragraph(),
            'isbn' => '1234561238932',
            'published' => now()->format('d-m-Y'),
            'publisher_id' => 1,
        ];
    }
}
