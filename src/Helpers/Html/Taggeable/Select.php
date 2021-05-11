<?php

namespace Sdkconsultoria\Base\Helpers\Html\Taggeable;

use Sdkconsultoria\Base\Helpers\Html\BaseHtml;
use Sdkconsultoria\Base\Helpers\Html\iHtml;
use Sdkconsultoria\Base\Models\Common\Tag\Tag;

/**
 *
 */
class Select extends BaseHtml implements iHtml
{
    protected $model;

    public static function make($model)
    {
        $object = new self;
        $object->model = $model;
        return $object;
    }

    protected function getOptions()
    {
        $tags = Tag::active()->get();
        $items = '';
        foreach ($tags as $tag) {
            $items .= '<option value="' . $tag->id . '">' . $tag->translate->name . '</option>';
        }

        return $items;
    }

    public function render()
    {
        return $this->menu();
    }

    public function menu()
    {
        return '
            <select id="taggable_' . $this->model->getTable() . '" class="form-control form-control-l form-control-r border-gray-300">
                <option value=""> --- </option>
                ' . $this->getOptions() . '
            </select>
            <button
            data-value="taggable_' . $this->model->getTable() . '"
            data-href="' . route('tag.add', ['class' => $this->model::class, 'id' => $this->model->id]) . '"
            type="button"
            class="btn btn-primary w-1/5 ml-3 taggable-button"> ' . Tag::getTranslate('add-element') . ' </button>
        ';
    }

}
