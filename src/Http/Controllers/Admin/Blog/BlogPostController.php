<?php

namespace Sdkconsultoria\Base\Http\Controllers\Admin\Blog;

use Sdkconsultoria\Base\Core\Controllers\ResourceController;

class BlogPostController extends ResourceController
{
    protected $model = \Sdkconsultoria\Base\Models\Blog\BlogPost::class;
}
