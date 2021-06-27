<?php

namespace Sdkconsultoria\Base\Http\Controllers\Admin;

use Sdkconsultoria\Base\Http\Controllers\ResourceController;

class ImageSizeController extends ResourceController
{
    protected $model = \Sdkconsultoria\Base\Models\Common\Image\ImageSize::class;
    protected $view = 'base::back.image-size.';
}
