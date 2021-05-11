<?php

namespace Sdkconsultoria\Base\Helpers\Html\Imageable;

use Sdkconsultoria\Base\Helpers\Html\BaseHtml;
use Sdkconsultoria\Base\Helpers\Html\iHtml;

/**
 *
 */
class Text extends BaseHtml implements iHtml
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
            <input value="' . $this->item->type . '" data-href="' . route('image.set-type', $this->item->id) . '" type="text" class="form-control form-control-l form-control-r border-gray-300 imageable-type" />
        ';
    }

}
