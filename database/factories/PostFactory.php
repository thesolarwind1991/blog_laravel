<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
    public function definition()
    {
        $name = fake()->realText(rand(70,100));
        return [
            'user_id' => rand(1,10),
            'category_id' => rand(1,12),
            'name' => $name,
            'excerpt' => fake()->realText(rand(300,400)),
            'content' => fake()->realText(rand(400,500)),
            'slug' => Str::slug($name),
            'published_by' => rand(1, 10),
        ];
    }
}
