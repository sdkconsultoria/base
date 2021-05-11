<?php

namespace Sdkconsultoria\Base\Http\Controllers\Admin;

use Sdkconsultoria\Base\Http\Controllers\ResourceController;
use Sdkconsultoria\Base\Traits\TranslateController;

class BlogController extends ResourceController
{
    use TranslateController;

    protected $model = \Sdkconsultoria\Base\Models\Blog\Blog::class;
    protected $translate = \Sdkconsultoria\Base\Models\Blog\BlogTranslate::class;
    protected $view = 'base::back.blogs.';
    protected $create_empty = true;
}
