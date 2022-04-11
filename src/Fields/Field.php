<?php

namespace Sdkconsultoria\Base\Fields;

abstract class Field
{
    public bool $visible_on_index = true;
    public bool $visible_on_create = true;
    public bool $visible_on_update = true;
    public bool $visible_on_details = true;
    public string $field;

    public static function make(string $field){
        $model =  new (get_called_class());
        $model->field = $field;

        return $model;
    }

    public function __toString(): string
    {
        return $this->field;
    }

    public function hideOnIndex()
    {
        $this->visible_on_index = false;

        return $this;
    }
}
