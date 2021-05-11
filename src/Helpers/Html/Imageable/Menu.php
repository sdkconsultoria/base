<?php

namespace Sdkconsultoria\Base\Helpers\Html\Imageable;

use Sdkconsultoria\Base\Helpers\Html\BaseHtml;
use Sdkconsultoria\Base\Helpers\Html\iHtml;
use Base;

/**
 *
 */
class Menu extends BaseHtml implements iHtml
{
    protected $item;

    public static function make($item)
    {
        $object = new self;
        $object->item = $item;
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
            data-href="' . route('image.destroy', $this->item->id) . '" class="delete-elements h-5 w-5 mr-1" type="button"> ' . Base::icon('trash') . ' </button>
        ';
    }

}
