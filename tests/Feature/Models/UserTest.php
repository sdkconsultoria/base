<?php

namespace Sdkconsultoria\Base\Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Sdkconsultoria\Base\Tests\Traits\Crud;

class UserTest extends TestCase
{
    // use Crud;

    private $model = \Sdkconsultoria\Base\Models\Blog\Blog::class;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreate()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
