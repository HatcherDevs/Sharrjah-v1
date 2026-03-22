<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Page>
 */
class PageFactory extends Factory
{
    protected $model = Page::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'name' => $name,
            'name_ar' => fake()->words(3, true),
            'slug' => \Illuminate\Support\Str::slug($name),
            'content' => fake()->paragraph(),
            'content_ar' => fake()->paragraph(),
            'page_type' => fake()->randomElement(['content', 'main', 'list']),
            'active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}