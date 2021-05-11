<?php

namespace Sdkconsultoria\Base\Helpers\Html\Taggeable;

use Sdkconsultoria\Base\Helpers\Html\BaseHtml;
use Sdkconsultoria\Base\Helpers\Html\iHtml;
use Base;

/**
 *
 */
class Menu extends BaseHtml implements iHtml
{
    protected $item;
    protected $model;

    public static function make($item, $model)
    {
        $object = new self;
        $object->item = $item;
        $object->model = $model;

        return $object;
    }

    public function render()
    {
        return $this->menu();
    }

    public function menu()
    {
        return '
            <button
            data-title="' . $this->item::getTranslate('delete_question') . '"
            data-confirm="' . $this->item::getTranslate('delete') . '"
            data-cancel="' . __('base::app.common.cancel') . '"
            data-href="' . route('tag.delete', ['class' => $this->model::class, 'tag' => $this->item->id, 'id' => $this->model->id]) . '"
            class="delete-elements h-5 w-5 mr-1" type="button"> ' . Base::icon('trash') . ' </button>
        ';
    }

}
