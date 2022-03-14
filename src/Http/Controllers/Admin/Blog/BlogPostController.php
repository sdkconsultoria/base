<?php

namespace Sdkconsultoria\Base\Http\Controllers\Admin\Blog;

use Sdkconsultoria\Base\Core\Controllers\ResourceApiController;

class BlogPostController extends ResourceApiController
{
    protected $model = \Sdkconsultoria\Base\Models\Blog\BlogPost::class;
}
