<?php

namespace Database\Factories;

use App\Models\LandingElement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LandingElement>
 */
class LandingElementFactory extends Factory
{
    protected $model = LandingElement::class;

    public function definition(): array
    {
        return [
            'title' => fake()->words(3, true),
            'title_ar' => fake()->words(3, true),
            'order' => fake()->numberBetween(1, 10),
            'is_main' => 0,
            'active' => 1,
        ];
    }
}