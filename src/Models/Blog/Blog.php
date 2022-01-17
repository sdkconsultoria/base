<?php

namespace Sdkconsultoria\Base\Models\Blog;

use Sdkconsultoria\Base\Core\Models\Model as BaseModel;
use Sdkconsultoria\Base\Core\Models\Traits\HasTranslate;
// use Sdkconsultoria\Base\Traits\TranslateModel;
// use Sdkconsultoria\Base\Traits\ImageTypeTrait;
// use Illuminate\Validation\Rule;

class Blog extends BaseModel
{
    use HasTranslate;

    public function getValidationRules($request = '')
    {
        return [
            'identifier' => 'required',
            'language' => 'required',
            'title' => 'required',
            'subtitle' => 'required',
            'description' => 'required',
        ];
    }

    // use TranslateModel;
    // use ImageTypeTrait;
    //
    // private $translateClass = BlogTranslate::class;
    // protected static $package = 'base';

    /**
     * Validaciones para crear el modelo.
     *
     * @return array
     */
    // public static function rules($request)
    // {
    //     return [
    //         'blogs_identifier' => [
    //             'required',
    //             Rule::unique('blogs', 'identifier')
    //         ],
    //     ];
    // }
}
