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
            'identifier' => $this->faker->unique()->word . $this->faker->unixTime(),
        ];
    }
}
