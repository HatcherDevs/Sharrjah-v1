<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'          => fake()->sentence(4),
            'title_ar'       => fake()->sentence(4),
            'slug'           => fake()->unique()->slug(),
            'description'    => fake()->sentence(),
            'description_ar' => fake()->sentence(),
            'publish_date'   => fake()->dateTimeThisYear(),
            'content'        => '<p>' . fake()->paragraph() . '</p>',
            'content_ar'     => '<p>' . fake()->paragraph() . '</p>',
            'page_id'        => null,
            'active'         => 1,
        ];
    }
}