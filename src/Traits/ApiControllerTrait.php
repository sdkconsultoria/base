<?php

namespace Sdkconsultoria\Base\Traits;

use Sdkconsultoria\Base\Exceptions\APIException;
use Illuminate\Http\Request;

/**
 * Permite crear REST API rapidamente
 */
trait ApiControllerTrait
{
    public function apiIndex(Request $request)
    {
        $model = new $this->model();

        return $this->filterResources($request, $model);
    }
    public function apiGet(string $id)
    {
        return $this->findModelApi($id);
    }

    public function apiCreate(Request $request)
    {

    }

    public function apiUpdate(Request $request, string $id)
    {

    }

    public function apiDelete(string $id)
    {

    }

    protected function findModelApi(string $id)
    {
        $model = $this->getModel($id);

        if (!$model) {
            throw new APIException(['message' => __('base::responses.404')], 404);
        }

        return $model;
    }
}
