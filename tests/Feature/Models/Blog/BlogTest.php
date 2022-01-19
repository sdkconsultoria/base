<?php

namespace Sdkconsultoria\Base\Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Sdkconsultoria\Base\Tests\Feature\Traits\LoginUser;
use Sdkconsultoria\Base\Tests\Feature\Traits\CrudTranslateApi\Crud;

class BlogTest extends TestCase
{
    use LoginUser;
    use Crud;

    private $model = \Sdkconsultoria\Base\Models\Blog\Blog::class;
}
