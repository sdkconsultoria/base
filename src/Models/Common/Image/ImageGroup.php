<?php

namespace Sdkconsultoria\Base\Models\Common\Image;

use Sdkconsultoria\Base\Models\Model as BaseModel;
use Sdkconsultoria\Base\Traits\TranslateModel;

class ImageGroup extends BaseModel
{
    use TranslateModel;

    private $translateClass = ImageGroupTranslate::class;
}
