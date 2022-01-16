<?php

namespace Sdkconsultoria\Base\Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Sdkconsultoria\Base\Tests\Traits\Crud;

class BlogTest extends TestCase
{
    // use Crud;

    private $model = \Sdkconsultoria\Base\Models\Blog\Blog::class;


    public function testCreate()
    {
        $model = $this->model::factory()->create();
        $translation = $model->getTranslatableModel()::factory([
            'blog_id' => $model->id
            ])->create();

        $this->assertDatabaseHas($model->getTable(), [
            'id' => $model->id,
        ]);

        $this->assertDatabaseHas($translation->getTable(), [
            'id' => $translation->id,
        ]);
    }
}
