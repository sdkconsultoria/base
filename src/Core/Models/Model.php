<?php

namespace Sdkconsultoria\Base\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sdkconsultoria\Base\Core\Models\Traits\Model as TraitBaseModel;
use Sdkconsultoria\Base\Core\Models\Traits\Authorize;
use Sdkconsultoria\Base\Core\Models\Traits\LoadFromRequest;

abstract class Model extends BaseModel
{
    use HasFactory;
    use TraitBaseModel;
    use Authorize;
    use LoadFromRequest;
    use SoftDeletes;

    public const DEFAULT_SEARCH = 'like';
    public const STATUS_DELETED = 0;
    public const STATUS_CREATION = 20;
    public const STATUS_ACTIVE = 30;

    // protected static $package = '';
    // public static $keyId = 'id';
}
