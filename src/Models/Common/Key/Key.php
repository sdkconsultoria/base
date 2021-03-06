<?php

namespace Sdkconsultoria\Base\Models\Common\Key;

use Sdkconsultoria\Base\Models\Model as BaseModel;
use Sdkconsultoria\Base\Traits\TranslateModel;

class Key extends BaseModel
{
    use TranslateModel;

    private $translateClass = KeyTranslate::class;
}
