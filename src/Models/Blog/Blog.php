<?php

namespace Sdkconsultoria\Base\Models\Blog;

use Sdkconsultoria\Core\Models\Model as BaseModel;
use Sdkconsultoria\Base\Fields\TextField;

class Blog extends BaseModel
{
    protected function fields()
    {
        return[
            TextField::make('title')->label('Título')->rules(['required']),
            TextField::make('subtitle')->label('Subtitulo')->rules(['required']),
            TextField::make('description')->label('Descripción')->rules(['required'])->hideOnIndex(),
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
