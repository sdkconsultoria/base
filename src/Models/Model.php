<?php

namespace Sdkconsultoria\Base\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sdkconsultoria\Base\Traits\BaseModel as TBaseModel;

abstract class Model extends BaseModel
{
    use HasFactory;
    use TBaseModel;
    use SoftDeletes;

    public const STATUS_DELETED = 0;
    public const STATUS_CREATION = 20;
    public const STATUS_ACTIVE = 30;

    protected static $package = '';
    public static $keyId = 'id';
}
