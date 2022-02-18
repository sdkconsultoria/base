<?php

namespace Sdkconsultoria\Base\Core\Models\Traits;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model as EloquentModel;

trait LoadFromRequest
{
    public function getApiEndpoint()
    {
        return strtolower(class_basename($this));
    }

    public function getValidationRules($request = '') : array
    {
        return [];
    }

    public function getUpdateValidationRules($request = '') : array
    {
        return $this->getValidationRules($request);
    }

    public function loadDataFromCreateRequest(Request $request) : void
    {
        $attributes = $this->getModelAttributesFromRules();
        $valid_attributes = $this->loadValidFieldsFromRequest($request, $attributes);

        $this->loadDataFromRequest($request, $valid_attributes);
    }

    public function loadDataFromUpdateRequest(Request $request) : void
    {
        $attributes = $this->getModelAttributesFromRules('getUpdateValidationRules');
        $valid_attributes = $this->loadValidFieldsFromRequest($request, $attributes);

        $this->loadDataFromRequest($request, $valid_attributes);
    }

    public function loadDataFromRequest(Request $request, array $atributes) : void
    {
        $this->assignValuesToModel($atributes, $this);
    }

    private function loadValidFieldsFromRequest(Request $request, array $attributes) : array
    {
        $valid_values = [];

        foreach ($request->all() as $attribute => $value) {
            if (in_array($attribute, $attributes)) {
                $valid_values[$attribute] = $value;
            }
        }

        return $valid_values;
    }

    private function assignValuesToModel(array $values, EloquentModel &$model ) : EloquentModel
    {
        foreach ($values as $attribute => $value) {
            $model->$attribute = $value;
        }

        return $model;
    }

    public function getModelAttributesFromRules(string $rules = 'getValidationRules', $request = '') : array
    {
        $rules_array = $this->$rules($request);
        $attributes = [];

        foreach ($rules_array as $attribute => $rule) {
            array_push($attributes, $attribute);
        }

        return $attributes;
    }
}
