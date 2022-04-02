<?php

namespace Sdkconsultoria\Base\Factories\Blog;

use Sdkconsultoria\Base\Models\Blog\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Blog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'subtitle' => $this->faker->word,
            'description' => $this->faker->text(),
            'status' => $this->model::STATUS_ACTIVE,
        ];
    }
}
