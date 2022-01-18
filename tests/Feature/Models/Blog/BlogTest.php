<?php

namespace Sdkconsultoria\Base\Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Sdkconsultoria\Base\Tests\Feature\Traits\CrudTranslateApi\Create;
use Sdkconsultoria\Base\Tests\Feature\Traits\CrudTranslateApi\Read;
use Sdkconsultoria\Base\Tests\Feature\Traits\CrudTranslateApi\Update;
use Sdkconsultoria\Base\Tests\Feature\Traits\CrudTranslateApi\Delete;
use Sdkconsultoria\Base\Tests\Feature\Traits\LoginUser;

class BlogTest extends TestCase
{
    // use Create;
    // use Read;
    use Update;
    // use Delete;
    use LoginUser;

    private $model = \Sdkconsultoria\Base\Models\Blog\Blog::class;
}
