<?php

namespace Sdkconsultoria\Base\Helpers\Html;

use Base;

/**
 * Permite cargar la configuracion de un modelo
 * Puede ser imagenes, tipos de imagenes, tamaños de imagenes, tags.
 * Modelos relacionados, Keys.
 */
class Setting extends BaseHtml
{
    private $model;

    function __construct($model)
    {
        $this->model = $model;
    }

    public static function generate($model)
    {
        return new self($model);
    }

    public function render() : string
    {
        return '';
        return Base::icon('cog', ['class' => 'h-6 mb-2']);
        return 'holis';
    }
}
