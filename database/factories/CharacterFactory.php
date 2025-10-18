<?php

namespace Database\Factories;

use App\Models\Anime;
use App\Models\Character;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Character>
 */
class CharacterFactory extends Factory
{
    protected $model = Character::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->name();

        return [
            'slug' => Str::slug($name . '-' . $this->faker->unique()->randomNumber()),
            'name' => $name,
            'role' => $this->faker->sentence(4),
            'anime_id' => Anime::factory(),
        ];
    }
}
