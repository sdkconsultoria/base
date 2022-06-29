<?php

namespace Sdkconsultoria\Base\Models\Common\Tag;

use Sdkconsultoria\Base\Models\Model as BaseModel;
use Sdkconsultoria\Base\Traits\TranslateModel;

class Tag extends BaseModel
{
    use TranslateModel;

    private $translateClass = TagTranslate::class;

    protected static $package = 'base';
}
