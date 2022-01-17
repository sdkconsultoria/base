<?php

namespace Sdkconsultoria\Base\Core\Controllers\Traits;

use Sdkconsultoria\Base\Exceptions\APIException;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Factory;

/**
 * Permite crear REST API rapidamente
 */
trait ApiControllerTrait
{
    public function store(Request $request)
    {

    }

    // public function apiIndex(Request $request)
    // {
    //     $model = new $this->model();
    //
    //     return $this->filterResources($request, $model);
    // }
    // public function apiGet(string $id)
    // {
    //     return $this->findModelApi($id);
    // }
    //
    // public function apiCreate(Request $request)
    // {
    //     $this->validateAPI($request, $this->model::rules($request));
    //
    //     $model = new $this->model;
    //     $model->status = $this->model::STATUS_ACTIVE;
    //     $this->loadData($model, $request);
    //     $model->created_by = \Auth::user()->id;
    //     $model->save();
    // }
    //
    // public function apiUpdate(Request $request, string $id)
    // {
    //     $this->validateAPI($request, $this->model::updateRules($request));
    //     $model = $this->getModel($id);
    //     $this->loadData($model, $request);
    //     $model->updated_by = \Auth::user()->id;
    //     $model->save();
    // }
    //
    // public function apiDelete(string $id)
    // {
    //     $model = $this->getModel($id);
    //     $model->status = $this->model::STATUS_DELETED;
    //     $model->deleted_at = date('Y-m-d H:i:s');
    //     $model->save();
    // }
    //
    // protected function findModelApi(string $id)
    // {
    //     $model = $this->getModel($id);
    //
    //     if (!$model) {
    //         throw new APIException(['message' => __('base::responses.404')], 404);
    //     }
    //
    //     return $model;
    // }
    //
    // protected function validateAPI(Request $request, $rules) : void
    // {
    //     $validator = app(Factory::class)->make($request->all(), $this->model::rules($request), [], []);
    //     if ($validator->fails()) {
    //         throw new APIException([
    //             'message' => __('base::responses.400'),
    //             'errors' => $this->parseErrors($validator->errors())
    //         ], 400);
    //     }
    // }
    //
    // protected function parseErrors($errors)
    // {
    //     $table = (new $this->model())->getTable();
    //
    //     $array_errors = $errors->toArray();
    //     foreach ($array_errors as $key => $value) {
    //         $attribute = $this->getAttributeFromKey($key, $table);
    //         $full_attribute = $table . '_' . $attribute;
    //         $full_attribute = str_replace('_', ' ', $full_attribute);
    //         $array_errors[$key] = str_replace($full_attribute, $this->model::getLabel($attribute), $value);
    //     }
    //
    //     return $array_errors;
    // }
    //
    // protected function getAttributeFromKey($key, $table)
    // {
    //     return substr(explode($table, $key)[1], 1);
    // }
}
