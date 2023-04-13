<?php

namespace Sdkconsultoria\Base\Services;

class MenuService
{
    protected $elements = [];

    public function getMenu(): array
    {
        return $this->elements;
    }

    public function addElement(array $element, array $roles = [])
    {
        $element['roles'] = $roles;
        $this->elements[] = $element;
    }

    public function removeElement(int $index)
    {
        unset($this->elements[$index]);
    }
}
