<?php

namespace Database\Factories;

use App\Models\Option;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Option>
 */
class OptionFactory extends Factory
{
    protected $model = Option::class;

    public function definition(): array
    {
        $slug = fake()->unique()->slug(2);

        return [
            'name' => fake()->words(2, true),
            'slug' => $slug,
            'value' => fake()->sentence(),
        ];
    }
}