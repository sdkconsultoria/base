<?php

namespace Sdkconsultoria\Base\Traits;

use Sdkconsultoria\Base\Exceptions\APIException;

/**
 * Permite crear REST API rapidamente
 */
trait ApiControllerTrait
{
    public function apiIndex()
    {
        return $this->model::all();
    }
    public function apiGet(string $id)
    {
        return $this->findApiModel($id);
    }

    public function apiCreate()
    {

    }

    public function apiUpdate(string $id)
    {

    }

    public function apiDelete(string $id)
    {

    }

    protected function findApiModel(string $id)
    {
        $model = $this->model::find($id);

        if (!$model) {
            throw new APIException(['message' => __('base::responses.404')], 404);
        }

        return $model;
    }
}
