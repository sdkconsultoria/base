<?php

namespace Sdkconsultoria\Base\Core\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Str;
use Sdkconsultoria\Base\Core\Controllers\Traits\SearchableTrait;
use Sdkconsultoria\Base\Core\Controllers\Traits\OrderableTrait;

/**
 * Permite crear REST API rapidamente
 */
trait ApiControllerTrait
{
    use SearchableTrait;
    use OrderableTrait;

    public function viewAny(Request $request)
    {
        $model = new $this->model;
        $model->isAuthorize('viewAny');

        $query = $model;
        $query = $this->searchable($query, $request);
        $query = $this->applyOrderByToQuery($query, $request->input('order'));
        $query = $query->get();

        return $query;
    }

    public function view(Request $request, $id)
    {
        $model = $this->model::findModel($id);
        $model->isAuthorize('view');

        return response()
            ->json(['model' => $model->getAttributes()]);
    }

    public function storage(Request $request)
    {
        $model = $this->model::findModelOrCreate();
        $model->isAuthorize('create');
        $model->loadDataFromCreateRequest($request);
        $model->status = $model::STATUS_ACTIVE;
        $model->save();

        return response()
            ->json(['model' => $model->getAttributes()]);
    }

    public function update(Request $request, $id)
    {
        $model = $this->model::findModel($id);
        $model->isAuthorize('update');
        $model->loadDataFromCreateRequest($request);
        $model->save();

        return response()
            ->json(['model' => $model->getAttributes()]);
    }

    public function delete($id)
    {
        $model = $this->model::findModel($id);
        $model->isAuthorize('delete');
        $model->status = $model::STATUS_DELETED;
        $model->delete();

        return response()
            ->json(['model' => $model->getAttributes()]);
    }
}
