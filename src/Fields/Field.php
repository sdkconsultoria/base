<?php

namespace Sdkconsultoria\Base\Fields;

abstract class Field
{
    public bool $visible_on_index = true;
    public bool $visible_on_create = true;
    public bool $visible_on_update = true;
    public bool $visible_on_show = true;
    public string $field;
    public array $rules;
    public string $label;
    public array $searchable;
    public array $filter;

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

    public function label(string $label) : self
    {
        $this->label = $label;

        return $this;
    }

    public function rules(array $rules)
    {
        $this->rules = $rules;

        return $this;
    }

    public function searchable(bool $searchable)
    {
        $this->searchable = $searchable;

        return $this;
    }

    public function getField(): array
    {
        return [
            'type' => $this->field_type,
            'name' => $this->field,
            'label' => $this->label,
            'rules' => $this->rules,
            'visible_on' => [
                'index' => $this->visible_on_index,
                'update' => $this->visible_on_update,
                'create' => $this->visible_on_create,
                'update' => $this->visible_on_update,
                'show' => $this->visible_on_show,
            ],
            'filter' => $this->field,
        ];
    }
}
