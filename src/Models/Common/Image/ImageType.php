<?php

namespace Sdkconsultoria\Base\Models\Common\Image;

use Sdkconsultoria\Base\Models\Model as BaseModel;
use Sdkconsultoria\Base\Traits\TranslateModel;

class ImageType extends BaseModel
{
    use TranslateModel;

    private $translateClass = ImageTypeTranslate::class;

    protected static $package = 'base';
}
