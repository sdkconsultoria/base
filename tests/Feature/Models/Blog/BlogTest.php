<?php

namespace Sdkconsultoria\Base\Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Sdkconsultoria\Base\Tests\Feature\Traits\CrudTranslateApi;
use Sdkconsultoria\Base\Tests\Feature\Traits\LoginUser;

class BlogTest extends TestCase
{
    use CrudTranslateApi;
    use LoginUser;

    private $model = \Sdkconsultoria\Base\Models\Blog\Blog::class;
}
