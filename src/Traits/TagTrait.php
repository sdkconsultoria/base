<?php

namespace Sdkconsultoria\Base\Traits;

use Sdkconsultoria\Base\Models\Common\Tag\Tag;

trait TagTrait
{
    /**
     * Obtiene todos los tags para el modelo.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
