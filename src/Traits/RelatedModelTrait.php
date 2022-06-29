<?php

namespace Sdkconsultoria\Base\Traits;

use Sdkconsultoria\Base\Models\Common\RelatedModel;
use Sdkconsultoria\Base\Models\Model;

trait RelatedModelTrait
{
    public $model;

    /**
     * Obtiene los modelos relacionados.
     *
     * @param  string  $model Modelo en especifico.
     * @return [type]        [description]
     */
    public function getRelated(string $model = '')
    {
        $model = $model ? $model : get_called_class();

        return RelatedModel::where('relatable_id', $this->id)
        ->where('relatable_type', get_called_class())
        ->where('modeleable_type', $model)
        ->with('modeleable')
        ->get();
    }

    /**
     * Guarda un modelo relacionado
     *
     * @param  string  $model Modelo en especifico.
     * @return RelatedModel
     */
    public function saveRelated(Model $model)
    {
        $this->model = $model;

        return $this->findReladed();
    }

    /**
     * Elimina un modelo relacionado
     *
     * @param  string  $model Modelo en especifico.
     * @return RelatedModel
     */
    public function deleteRelated(Model $model)
    {
        $this->model = $model;

        return $this->findReladed()->forceDelete();
    }

    /**
     * Encuentra o crea un modelo
     *
     * @return RelatedModel
     */
    protected function findReladed()
    {
        return RelatedModel::firstOrCreate([
            'relatable_id' => $this->id,
            'relatable_type' => get_called_class(),
            'modeleable_id' => $this->model->id,
            'modeleable_type' => $this->model::class,
        ]);
    }
}
