<?php

namespace Sdkconsultoria\Base\Core\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Str;

/**
 * Permite crear REST API rapidamente
 */
trait ApiControllerTrait
{
    public function storage(Request $request)
    {
        $model = $this->model::findModelOrCreate();
        $model->isAuthorize('create');
        $model->loadDataFromCreateRequest($request);
        $model->status = $model::STATUS_ACTIVE;
        $model->save();

        if ($model->isTranstlatableModel()) {
            $translate_model = $model->getTranslatableModel();
            $translate_model->status = $translate_model::STATUS_ACTIVE;
            $translate_model->save();
        }

        return response()
            ->json(['model' => $model->getFullAttributes()]);
    }

    public function update(Request $request, $id)
    {
        $model = $this->model::findModel($id);
        $model->isAuthorize('update');
        $model->loadDataFromCreateRequest($request);
        $model->save();

        if ($model->isTranstlatableModel()) {
            $translate_model = $model->getTranslatableModel();
            $translate_model->save();
        }

        return response()
            ->json(['model' => $model->getFullAttributes()]);
    }

    public function delete($id)
    {
        $model = $this->model::findModel($id);
        $model->isAuthorize('delete');
        $model->status = $model::STATUS_DELETED;
        $model->delete();

        if ($model->isTranstlatableModel()) {
            $translate_model = $model->getTranslatableModel();
            $translate_model->status = $translate_model::STATUS_DELETED;
            $translate_model->delete();
        }

        return response()
            ->json(['model' => $model->getFullAttributes()]);
    }

    public function view(Request $request, $id)
    {
        $model = $this->model::findModel($id);
        $model->isAuthorize('view');

        return response()
            ->json(['model' => $model->getFullAttributes()]);    }

    public function viewAny(Request $request)
    {
        $model = new $this->model;
        $model->isAuthorize('viewAny');
    }
}
