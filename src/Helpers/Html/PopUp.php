<?php

namespace Sdkconsultoria\Base\Helpers\Html;

use Base;

/**
 *
 */
class PopUp extends BaseHtml implements iHtml
{

    function __construct()
    {
        // $this->items = $items;
    }

    public static function make()
    {
        $model = new self();

        return $model;
    }

    public static function finish()
    {
        $model = new self();

        return $model;
    }

    /**
     * Convierte esta clase a un html valido
     * @return string
     */
    public function render()
    {
        $html = '';

        return $html;
    }
}
