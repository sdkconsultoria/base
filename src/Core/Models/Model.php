<?php

namespace Sdkconsultoria\Base\Core\Models;

use Sdkconsultoria\Base\Core\Models\Traits\BaseModel as TraitBaseModel;
use Illuminate\Database\Eloquent\Model as BaseModel;

abstract class Model extends BaseModel
{
    use TraitBaseModel;

    public const DEFAULT_SEARCH = 'like';
    public const STATUS_DELETED = 0;
    public const STATUS_CREATION = 20;
    public const STATUS_ACTIVE = 30;
}
