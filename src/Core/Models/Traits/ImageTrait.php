<?php

namespace Sdkconsultoria\Base\Core\Models\Traits;

use Sdkconsultoria\Base\Models\Common\Image\Image;

trait ImageTrait
{
    /**
     * Obtiene todas las fotos.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Obtiene una foto.
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
