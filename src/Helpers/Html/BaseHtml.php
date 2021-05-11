<?php

namespace Sdkconsultoria\Base\Helpers\Html;

/**
 *
 */
abstract class BaseHtml
{

    public static function setAttributes(array $options = [])
    {
        $attributes = '';

        foreach ($options as $key => $attribute) {
            $attributes .= $key.'="'.$attribute.'"';
        }

        return $attributes;
    }

    public function __toString()
    {
        return $this->render();
    }

}
