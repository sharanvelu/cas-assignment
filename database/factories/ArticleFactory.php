<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->title,
            'content' => $this->faker->text,
            'status' => $this->faker->randomElement(['draft', 'scheduled', 'published']),
            'project_id' => Project::query()->inRandomOrder()->first()->id,
            'user_id' => User::query()->inRandomOrder()->first()->id,
            'meta_title' => $this->faker->title,
            'meta_description' => $this->faker->realText,
            'featured_image' => $this->faker->filePath(),
        ];
    }
}
