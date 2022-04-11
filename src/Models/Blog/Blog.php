<?php

namespace Sdkconsultoria\Base\Models\Blog;

use Sdkconsultoria\Core\Models\Model as BaseModel;
use Sdkconsultoria\Base\Fields\TextField;

class Blog extends BaseModel
{
    protected function fields()
    {
        return[
            TextField::make('title'),
            TextField::make('subtitle'),
            TextField::make('description')->hideOnIndex(),
        ];
    }

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

    public function getTranslations() : array
    {
        return [
            'singular' => 'Blog',
            'plural' => 'Blogs',
        ];
    }
}
