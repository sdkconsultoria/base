<?php

namespace Sdkconsultoria\Base\Factories\Blog;

use \Sdkconsultoria\Base\Models\Blog\BlogTranslate;
use \Sdkconsultoria\Base\Models\Blog\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogTranslateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BlogTranslate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'blog_id' => Blog::factory(),
            // 'identifier' => $this->faker->unique()->word,
            'status' => $this->model::STATUS_ACTIVE,
        ];
    }
}
