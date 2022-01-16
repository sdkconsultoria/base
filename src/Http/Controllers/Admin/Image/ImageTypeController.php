<?php

namespace Sdkconsultoria\Base\Http\Controllers\Admin;

use Sdkconsultoria\Base\Http\Controllers\ResourceController;
use Sdkconsultoria\Base\Traits\TranslateController;

class ImageTypeController extends ResourceController
{
    use TranslateController;

    protected $model = \Sdkconsultoria\Base\Models\Common\Image\ImageType::class;
    protected $translate = \Sdkconsultoria\Base\Models\Common\Image\ImageTypeTranslate::class;
    protected $view = 'base::back.image-types.';
    protected $create_empty = true;
}
