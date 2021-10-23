<?php

namespace Sdkconsultoria\Base\Models\Blog;

use Sdkconsultoria\Base\Models\Model as BaseModel;
use Sdkconsultoria\Base\Traits\TranslateModel;
use Sdkconsultoria\Base\Traits\TagTrait;
use Illuminate\Validation\Rule;
use Sdkconsultoria\Base\Traits\RelatedModelTrait;

class BlogPost extends BaseModel
{
    use TranslateModel;
    use TagTrait;
    use RelatedModelTrait;

    private $translateClass = BlogPostTranslate::class;
    protected static $package = 'base';

    /**
     * Validaciones para crear el modelo.
     *
     * @return array
     */
    public static function rules($request)
    {
        return [
            'blog_posts_identifier' => [
                'required',
                Rule::unique('blog_posts', 'identifier')->ignoreModel($request->model)
            ],
            'blog_posts_blog_id' => 'required',
        ];
    }

    /**
     * Obtiene el blog de este post.
     */
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    public function select(string $type)
    {
        switch ($type) {
            case 'blog':
                return Blog::active()->get()->pluck('identifier', 'id')->toArray();
                break;
        }
    }
}
