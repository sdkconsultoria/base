<?php

namespace Sdkconsultoria\Base\Models\Blog;

use Sdkconsultoria\Core\Models\Model as BaseModel;
// use Sdkconsultoria\Base\Traits\TagTrait;
use Illuminate\Validation\Rule;

class BlogPost extends BaseModel
{
    public function getValidationRules($request = '') : array
    {
        return [
            'title' => 'required',
            'subtitle' => 'required',
            'description' => 'required',
            'blog_id' => 'required',
            // 'blog_posts_identifier' => [
            //     'required',
            //     Rule::unique('blog_posts', 'identifier')->ignoreModel($request->model)
            // ],
        ];
    }

    public function getLabels() : array
    {
        return [
            'title' => 'Título',
            'subtitle' => 'Subtitulo',
            'description' => 'Descripción',
            'blog_id' => 'Blog',
        ];
    }

    public function select(string $type)
    {
        switch ($type) {
            case 'blog':
                return Blog::active()->get()->pluck('identifier', 'id')->toArray();
                break;
        }
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
