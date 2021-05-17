<?php

namespace Sdkconsultoria\Base\Http\Controllers\Admin;

use Sdkconsultoria\Base\Http\Controllers\ResourceController;

class KeyGroupController extends ResourceController
{
    protected $model = \Sdkconsultoria\Base\Models\Common\Key\KeyGroup::class;
    protected $translate = \Sdkconsultoria\Base\Models\Common\Key\KeyGroupTranslate::class;
    protected $view = 'base::back.key-group.';
    protected $create_empty = true;
}
