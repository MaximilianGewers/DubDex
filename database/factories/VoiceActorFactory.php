<?php

namespace Database\Factories;

use App\Models\VoiceActor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<VoiceActor>
 */
class VoiceActorFactory extends Factory
{
    protected $model = VoiceActor::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->name();

        return [
            'slug' => Str::slug($name . '-' . $this->faker->unique()->randomNumber()),
            'name' => $name,
            'language' => $this->faker->randomElement(['Japanese', 'English', 'Spanish', 'French']),
        ];
    }
}
