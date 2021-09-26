<?php

namespace Sdkconsultoria\Base\Models\Ecommerce;

use Sdkconsultoria\Base\Models\Model as BaseModel;
use Sdkconsultoria\Base\Traits\TranslateModel;

class Category extends BaseModel
{
    use TranslateModel;

    private $translateClass = CategoryTranslate::class;
    protected static $package = 'base';
}
