<?php

namespace Sdkconsultoria\Base\Helpers\Html;

use Route;
use Base;

/**
 *
 */
class Breadcrumb extends BaseHtml implements iHtml
{
    protected $items;

    function __construct(array $items)
    {
        $this->items = $items;
    }

    public static function make(array $items)
    {
        $sidebar = new self($items);

        return $sidebar;
    }

    protected function items()
    {
        $html = '';
        $current = array_pop($this->items);;
        foreach ($this->items as $key => $value) {
            $html .= '<li class="px-4"><a href="' . $key . '">' . $value . '</a></li>';
        }

        $html .= '<li class="px-4 text-gray-700" aria-current="page">' . $current . '</li>';

        return $html;
    }

    /**
     * Convierte esta clase a un html valido
     * @return string
     */
    public function render()
    {
        $html = '
            <nav class="bg-white p-3 mb-6 rounded-lg shadow-md" aria-label="breadcrumb">
                <ol class="flex leading-none text-cyan-600 divide-x divide-indigo-400">
                    <li class="pr-4"><a href="' . route('dashboard') . '">' . __('core::app.dashboard') . '</a></li>
                    ' . $this->items() . '

                </ol>
            </nav>
        ';

        return $html;
    }

}
