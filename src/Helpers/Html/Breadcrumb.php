<?php

namespace Sdkconsultoria\Base\Helpers\Html;

use Base;

class Breadcrumb extends BaseHtml implements iHtml
{
    protected $items;

    public function __construct(array $items)
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
        $current = array_pop($this->items);
        foreach ($this->items as $key => $value) {
            $html .= '<li>'.Base::icon('folder', ['class' => 'h-5 mr-1']).'<a href="'.$key.'">'.$value.'</a></li>';
        }

        $html .= '<li>'.Base::icon('folder-open', ['class' => 'h-5 mr-1']).$current.'</li>';

        return $html;
    }

    /**
     * Convierte esta clase a un html valido
     *
     * @return string
     */
    public function render()
    {
        $html = '
            <div class="text-sm breadcrumbs mb-3">
                <ul>
                    <li><a href="'.route('dashboard').'"> '.Base::icon('folder', ['class' => 'h-5 mr-1']).'Dashboard</a></li>
                    '.$this->items().'
                </ul>
            </div>
        ';

        return $html;
    }
}
