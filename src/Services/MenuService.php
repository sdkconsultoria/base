<?php

namespace Sdkconsultoria\Base\Services;

class MenuService
{
    protected $elements = [];

    public function getMenu(): array
    {
        return $this->elements;
    }

    public function addElement(array $element)
    {
        $this->elements[] = $element;
    }
}