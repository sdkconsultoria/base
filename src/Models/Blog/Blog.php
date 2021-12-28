<?php

namespace Sdkconsultoria\Base\Models\Blog;

use Sdkconsultoria\Base\Models\Model as BaseModel;
use Sdkconsultoria\Base\Traits\TranslateModel;
use Sdkconsultoria\Base\Traits\ImageTypeTrait;
use Illuminate\Validation\Rule;

class Blog extends BaseModel
{
    use TranslateModel;
    use ImageTypeTrait;

    private $translateClass = BlogTranslate::class;
    protected static $package = 'base';

    /**
     * Validaciones para crear el modelo.
     *
     * @return array
     */
    public static function rules($request)
    {
        return [
            'blogs_identifier' => [
                'required',
                Rule::unique('blogs', 'identifier')
            ],
        ];
    }
}
