<?php

namespace Sdkconsultoria\Base\Http\Controllers\Admin;

use Sdkconsultoria\Base\Http\Controllers\ResourceController;
use Sdkconsultoria\Base\Traits\TranslateController;

class ImageGroupController extends ResourceController
{
    use TranslateController;

    protected $model = \Sdkconsultoria\Base\Models\Common\Image\ImageGroup::class;
    protected $translate = \Sdkconsultoria\Base\Models\Common\Image\ImageGroupTranslate::class;
    protected $view = 'base::back.image-groups.';
    protected $create_empty = true;
}
