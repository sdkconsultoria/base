<?php

namespace Sdkconsultoria\Base\Models\Blog;

use Sdkconsultoria\Base\Models\Model as BaseModel;

class BlogTranslate extends BaseModel
{
    protected static $package = 'base';

    /**
     * Validaciones para crear el modelo.
     *
     * @return array
     */
    public static function rules()
    {
        return [
            'blog_translates_title' => 'required',
            'blog_translates_description' => 'required',
            'blog_translates_language' => 'required',
        ];
    }
}
