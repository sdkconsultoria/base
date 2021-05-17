<?php

namespace Sdkconsultoria\Base\Models\Common\Key;

use Sdkconsultoria\Base\Models\Model as BaseModel;
use Sdkconsultoria\Base\Traits\TranslateModel;

class KeyGroup extends BaseModel
{
    use TranslateModel;

    private $translateClass = KeyGroupTranslate::class;
}
