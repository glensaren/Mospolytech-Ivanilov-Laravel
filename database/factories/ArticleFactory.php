<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->sentence(3);
        
        return [
            'title' => $title,
            'content' => $this->faker->paragraphs(5, true),
            'short_description' => $this->faker->sentence(10),
            'author' => $this->faker->name(),
            'publication_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'category' => $this->faker->randomElement(['Технологии', 'Наука', 'Образование', 'Культура', 'Спорт', 'Политика']),
            'preview_image' => $this->faker->randomElement(['preview.jpg', 'preview_2.jpg']),
            'is_published' => $this->faker->boolean(90), // 90% статей опубликованы
            'views_count' => $this->faker->numberBetween(0, 10000),
        ];
    }
}