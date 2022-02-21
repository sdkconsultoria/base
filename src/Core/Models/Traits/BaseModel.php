<?php

namespace Sdkconsultoria\Base\Core\Models\Traits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sdkconsultoria\Base\Core\Models\Traits\Model as TraitBaseModel;
use Sdkconsultoria\Base\Core\Models\Traits\Authorize;
use Sdkconsultoria\Base\Core\Models\Traits\LoadFromRequest;

trait BaseModel
{
    use HasFactory;
    use TraitBaseModel;
    use Authorize;
    use LoadFromRequest;
    use SoftDeletes;
}
