<?php

namespace Sdkconsultoria\Base\Http\Controllers\Admin;

use Sdkconsultoria\Base\Http\Controllers\ResourceController;

class ProductController extends ResourceController
{
    use TranslateController;

    protected $model = \Sdkconsultoria\Base\Models\Ecommerce\Product::class;
    protected $translate = \Sdkconsultoria\Base\Models\Ecommerce\ProductTranslate::class;
    protected $view = 'base::back.product.';
    protected $create_empty = true;
}
