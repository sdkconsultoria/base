<?php

namespace Sdkconsultoria\Base\Helpers\Html;

/**
 *
 */
class Img extends BaseHtml
{
    private $rute;
    private $optionsHtml;
    private $getOptimize = true;

    function __construct(string $rute, array $optionsHtml = [])
    {
        $this->rute = asset($rute);
        $this->optionsHtml = self::setAttributes($optionsHtml);
    }

    public function render()
    {
        return '<img src="' . $this->rute . '" ' . $this->optionsHtml . '>';
    }

}
