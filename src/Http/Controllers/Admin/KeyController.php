<?php

namespace Sdkconsultoria\Base\Http\Controllers\Admin;

use Sdkconsultoria\Base\Http\Controllers\ResourceController;
use Sdkconsultoria\Base\Traits\TranslateController;

class KeyController extends ResourceController
{
    use TranslateController;

    protected $model = \Sdkconsultoria\Base\Models\Common\Key\Key::class;
    protected $translate = \Sdkconsultoria\Base\Models\Common\Key\KeyTranslate::class;
    protected $view = 'base::back.key.';
    protected $create_empty = true;
}
