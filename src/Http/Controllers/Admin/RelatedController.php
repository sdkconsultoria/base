<?php

namespace Sdkconsultoria\Base\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Sdkconsultoria\Base\Models\Common\RelatedModel;

class RelatedController extends Controller
{
    /**
     * Crea un nuevo modelo relacionado.
     * @param  [type] $id      [description]
     * @param  [type] $model   [description]
     * @param  [type] $id_2    [description]
     * @param  [type] $model_2 [description]
     * @return [type]          [description]
     */
    public function create($id, $model, $id_2, $model_2)
    {
        return $this->findReladed($id, $model, $id_2, $model_2);
    }

    /**
     * Elimina un nuevo modelo relacionado.
     * @param  [type] $id      [description]
     * @param  [type] $model   [description]
     * @param  [type] $id_2    [description]
     * @param  [type] $model_2 [description]
     * @return [type]          [description]
     */
    public function delete($id, $model, $id_2, $model_2)
    {
        $this->model = $model;
        return $this->findReladed($id, $model, $id_2, $model_2)->forceDelete();
    }

    /**
     * Encuentra o crea un modelo
     * @return RelatedModel
     */
    protected function findReladed($id, $model, $id_2, $model_2)
    {
        return RelatedModel::firstOrCreate([
            'relatable_id' => $this->id,
            'relatable_type' => get_called_class(),
            'modeleable_id' => $this->model->id,
            'modeleable_type' => $this->model::class,
        ]);
    }
}
