<?php

namespace Sdkconsultoria\Base\Http\Controllers\Admin;

use Sdkconsultoria\Base\Http\Controllers\ResourceController;
use Sdkconsultoria\Base\Traits\TranslateController;

class BlogPostController extends ResourceController
{
    use TranslateController;

    protected $model = \Sdkconsultoria\Base\Models\Blog\BlogPost::class;
    protected $translate = \Sdkconsultoria\Base\Models\Blog\BlogPostTranslate::class;
    protected $view = 'base::back.blog-posts.';
    protected $create_empty = true;
}
