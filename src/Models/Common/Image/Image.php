<?php

namespace Sdkconsultoria\Base\Models\Common\Image;

use Sdkconsultoria\Base\Helpers\Html\Imageable\Imageable;
use Sdkconsultoria\Core\Models\Model as BaseModel;
use Sdkconsultoria\Base\Helpers\Images;
use Sdkconsultoria\Base\Traits\ImageTypeTrait;
use Request;

class Image extends BaseModel
{
    use ImageTypeTrait;
    protected static $package = 'base';

    public function convertImage()
    {
        $table = new $this->imageable_type;

        Images::convertImage('images/' . $table->getTable() .'/' . $this->imageable_id . '/', $this->id, $this->extension);
    }

    /**
     * Obtiene el padre del modelo imageable model.
     */
    public function imageable()
    {
        return $this->morphTo();
    }

    public function url(string $size = 'medium') : string
    {
        $table = new $this->imageable_type;
        $format = '.jpg';

        if (strpos(Request::server('HTTP_ACCEPT'), 'webp') !== false) {
            $format = '.webp';
        }

        return asset('storage/images/' . $table->getTable() . '/' . $this->imageable_id . '/' . $this->id . '-' . $size . $format);
    }

    public function image(string $size = 'medium', array $options = []) : string
    {
        return '
            <img src="' . $this->url($size) . '" ' . $this->setAttributes($options) . ' />
        ';
    }

    public function imagePreview(string $size = 'medium', string $target = 'large', array $options = []) : string
    {
        $options['class'] = $options['class'] ?? '';
        $options['class'] .= ' img-preview';

        return '
            <img target="'.$this->url($target).'" src="' . $this->url($size) . '" ' . $this->setAttributes($options) . ' />
        ';
    }

    private function setAttributes(array $options = [])
    {
        $attributes = '';

        foreach ($options as $key => $attribute) {
            $attributes .= $key.'="'.$attribute.'"';
        }

        return $attributes;
    }

    public function removeImage($rm_original = true)
    {
        $table = new $this->imageable_type;

        Images::removeImage('images/' . $table->getTable() . '/' . $this->imageable_id . '/' . $this->route, $this->id, $this->extension, $rm_original);
    }

    public function getRow()
    {
        $object = new $this->imageable_type;
        $imageable = new Imageable();
        $imageable->table = $object->getTable();
        return $imageable->row($this);
    }
}
