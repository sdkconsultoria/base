<?php

namespace Sdkconsultoria\Base\Models\Blog;

use Sdkconsultoria\Base\Core\Models\Model as BaseModel;
// use Sdkconsultoria\Base\Traits\ImageTypeTrait;
// use Illuminate\Validation\Rule;

class Blog extends BaseModel
{
    public function getValidationRules($request = '') : array
    {
        return [
            'title' => 'required',
            'subtitle' => 'required',
            'description' => 'required',
        ];
    }

    public static function getFilters() : array
    {
        return [
            'title',
            'subtitle',
        ];
    }

    public function getLabels() : array
    {
        return [
            'title' => 'Título',
            'subtitle' => 'Subtitulo',
            'description' => 'Descripción',
        ];
    }
}
