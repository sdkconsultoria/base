<?php

namespace Sdkconsultoria\Base\Factories\Blog;

use Sdkconsultoria\Base\Models\Blog\BlogTranslate;
use Sdkconsultoria\Base\Models\Blog\Blog;
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
            'translatable_id' => Blog::factory(),
            'title' => $this->faker->sentence,
            'subtitle' => $this->faker->sentence,
            'description' => $this->faker->text,
            'language' => 'es',
            'status' => $this->model::STATUS_ACTIVE,
        ];
    }
}
