<?php

namespace Database\Factories;

use App\Models\Anime;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Anime>
 */
class AnimeFactory extends Factory
{
    protected $model = Anime::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->sentence(3);

        return [
            'slug' => Str::slug($title . '-' . $this->faker->unique()->randomNumber()),
            'title' => $title,
            'synopsis' => $this->faker->paragraph(),
            'genres' => $this->faker->randomElements([
                'Action',
                'Adventure',
                'Comedy',
                'Fantasy',
                'Drama',
                'Science Fiction',
            ], 3),
        ];
    }
}
