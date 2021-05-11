<?php

namespace Sdkconsultoria\Base\Http\Controllers\Admin;

use Sdkconsultoria\Base\Http\Controllers\ResourceController;
use Sdkconsultoria\Base\Traits\TranslateController;
use Illuminate\Http\Request;
use Sdkconsultoria\Base\Helpers\Html\Taggeable\Taggeable;

class TagController extends ResourceController
{
    use TranslateController;

    protected $model = \Sdkconsultoria\Base\Models\Common\Tag\Tag::class;
    protected $translate = \Sdkconsultoria\Base\Models\Common\Tag\TagTranslate::class;
    protected $view = 'base::back.tag.';
    protected $create_empty = true;


    public function add(Request $request, $class, $id)
    {
        $object = $class::where('id', $id)->first();
        $object->tags()->attach($request->tag);
        $taggeable = new Taggeable();
        $taggeable->model = $object;

        return response()
        ->json([
            'data' => $taggeable->row($this->findModel($request->tag)),
            'table' => $object->getTable() . '_taggeable'
        ]);
    }

    public function delete($class, $tag, $id)
    {
        $object = $class::where('id', $id)->first();
        $object->tags()->detach($tag);

        return response()
        ->json([
            'data' => $object->getTable() . '_row_' . $id
        ]);
    }
}
