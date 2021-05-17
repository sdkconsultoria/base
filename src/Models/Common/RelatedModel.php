<?php

namespace Sdkconsultoria\Base\Models\Common;

use Sdkconsultoria\Base\Models\Model as BaseModel;

class RelatedModel extends BaseModel
{
    protected $fillable = ['relatable_id', 'relatable_type', 'modeleable_id', 'modeleable_type'];

    /**
     * Get the parent imageable model (user or post).
     */
    public function modeleable()
    {
        return $this->morphTo();
    }
}
