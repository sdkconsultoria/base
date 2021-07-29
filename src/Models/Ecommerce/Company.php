<?php

namespace Sdkconsultoria\Base\Models\Ecommerce;

use Sdkconsultoria\Base\Models\Model as BaseModel;
use Sdkconsultoria\Base\Traits\TranslateModel;

class Company extends BaseModel
{
    use TranslateModel;

    private $translateClass = CompanyTranslate::class;
}
