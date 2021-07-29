<?php

namespace Sdkconsultoria\Base\Http\Controllers\Admin;

use Sdkconsultoria\Base\Http\Controllers\ResourceController;

class CompanyController extends ResourceController
{
    use TranslateController;

    protected $model = \Sdkconsultoria\Base\Models\Ecommerce\Company::class;
    protected $translate = \Sdkconsultoria\Base\Models\Ecommerce\CompanyTranslate::class;
    protected $view = 'base::back.company.';
    protected $create_empty = true;
}
