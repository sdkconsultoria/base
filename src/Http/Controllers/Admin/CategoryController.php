<?php

namespace Sdkconsultoria\Base\Http\Controllers\Admin;

use Sdkconsultoria\Base\Http\Controllers\ResourceController;

class CategoryController extends ResourceController
{
    use TranslateController;

    protected $model = \Sdkconsultoria\Base\Models\Ecommerce\Category::class;
    protected $translate = \Sdkconsultoria\Base\Models\Ecommerce\CategoryTranslate::class;
    protected $view = 'base::back.category.';
    protected $create_empty = true;
}
