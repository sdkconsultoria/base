<?php

namespace Sdkconsultoria\Base\Traits;

use Sdkconsultoria\Base\Models\Common\Image\ImageType;

trait ImageTypeTrait
{
    /**
     * Obtiene los tipos de fotos.
     */
    public function imagesTypes()
    {
        return $this->morphMany(ImageType::class, 'imageable')->orWhere('imageable_type', null)->where('status', ImageType::STATUS_ACTIVE);
    }
}
