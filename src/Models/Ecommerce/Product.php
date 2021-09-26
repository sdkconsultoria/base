<?php

namespace Sdkconsultoria\Base\Models\Ecommerce;

use Sdkconsultoria\Base\Models\Model as BaseModel;
use Sdkconsultoria\Base\Traits\TranslateModel;

class Product extends BaseModel
{
    use TranslateModel;

    private $translateClass = ProductTranslate::class;
    protected static $package = 'base';
}
