<?php

namespace Sdkconsultoria\Base\Helpers\Html\Imageable;

use Sdkconsultoria\Base\Helpers\Html\BaseHtml;
use Sdkconsultoria\Base\Helpers\Html\iHtml;

/**
 *
 */
class Select extends BaseHtml implements iHtml
{
    protected $item;

    public static function make($item)
    {
        $object = new self;
        $object->item = $item;
        return $object;
    }

    protected function getOptions()
    {
        $items = '';
        foreach ($this->item->imagesTypes as $type) {
            $items .= '<option ' . ($this->item->type == $type->identifier ? 'selected' : '') . ' value="' . $type->identifier . '">' . $type->translate->name . '</option>';
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
            <select data-href="' . route('image.set-type', $this->item->id) . '" class="form-control form-control-l form-control-r border-gray-300 imageable-type">
                <option value=""> --- </option>
                ' . $this->getOptions() . '
            </select>
        ';
    }

}
