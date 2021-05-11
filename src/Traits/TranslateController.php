<?php

namespace Sdkconsultoria\Base\Traits;

use Illuminate\Http\Request;

trait TranslateController
{
    protected function createOrFind($params = [])
    {
        $model = $this->model::where('created_by', \Auth::user()->id)->where('status', $this->model::STATUS_CREATION)->first();

        if (!$model) {
            $model = new $this->model();
            $model->created_by = \Auth::user()->id;
            $model->status = $this->model::STATUS_CREATION;
            $model->save();

            $translate = new $this->translate;
            $translate->created_by = \Auth::user()->id;
            $translate->language = app()->getLocale();

            $class = $model->getClassName('snake', false) . '_id';
            $translate->{$class}= $model->id;
            $translate->save();
        }

        return $model;
    }

    /**
     * Guarda un modelo
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array_merge($this->model::rules(), $this->translate::rules()));

        $model = $this->createOrFind();
        $model->status = $this->model::STATUS_ACTIVE;
        $translate = $model->translate;

        $this->loadData($model, $request);
        $this->loadData($translate, $request);
        $model->created_by = \Auth::user()->id;
        $model->save();
        $translate->save();

        return redirect($model->getRoute('index'))->with('toast', [
            'type' => 'success',
            'text' => $this->model::getTranslate('created'),
        ]);
    }

    /**
     * Actualiza un modelo
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, array_merge($this->model::updateRules(), $this->translate::updateRules()));
        $model = $this->findModel($id);
        $translate = $model->translate;

        $this->loadData($model, $request);
        $this->loadData($translate, $request);
        $model->updated_by = \Auth::user()->id;
        $model->save();
        $translate->save();

        return redirect($model->getRoute('index'))->with('toast', [
            'type' => 'success',
            'text' => $this->model::getTranslate('edited'),
        ]);
    }

    /**
     * Añade una relacion a un modelo.
     * @param  builder $model modelo al cual se añadiran las relaciones
     * @param mixed $model
     * @return Builder modelo con las relaciones asignadas
     */
    protected function with($model)
    {
        return $model->with('translate');
    }
}
