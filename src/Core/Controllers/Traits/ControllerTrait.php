<?php

namespace Sdkconsultoria\Base\Traits;

use Illuminate\Http\Request;

trait ControllerTrait
{
    protected function loadData(&$model, $request)
    {
        foreach ($model->getTableColumns() as $key => $value) {
            if (!empty($request->input($model->getTable().'_'.$value)) || $request->input($model->getTable().'_'.$value) == '0') {
                $model->$value = $request->input($model->getTable().'_'.$value);
            }
        }
    }

    /**
     * Encuentra el modelo o lo crea
     * @param  array  $params               [description]
     * @return [type]         [description]
     */
    protected function createOrFind($params = [])
    {
        $model = $this->model::where('created_by', \Auth::user()->id);

        if ($params) {
            foreach ($params as $key => $value) {
                $model = $model->where($key, $value);
            }
        }

        $model = $model->where('status', $this->model::STATUS_CREATION)->first();

        if (!$model) {
            if ($this->create_empty) {
                $model = new $this->model();
                $model->status = $this->model::STATUS_CREATION;

                if ($model->hasColumn('created_by')) {
                    $model->created_by = \Auth::user()->id;
                }

                foreach ($params as $key => $value) {
                    $model->$key = $value;
                }

                $model->save();

                return $model;
            }

            return new $this->model();
        }

        return $model;
    }

    /**
     * Obtiene el status por default para buscar un usuario
     * Si devuelve false, no se aplicara ningun tipo de filtro por default a status
     * @return string
     */
    protected function getDefaultStatus($model)
    {
        return $this->model::where($model->getTable().'.status', $this->model::STATUS_ACTIVE);
    }

    /**
     * Añade una relacion a un modelo.
     * @param  builder $model modelo al cual se añadiran las relaciones
     * @param mixed $model
     * @return Builder modelo con las relaciones asignadas
     */
    protected function with($model)
    {
        return $model;
    }

    /**
     * Ordena los modelos conforme a un atributo.
     *
     * $order = 'id'; ordena los items de por ID de forma ascendente.
     * $order = 'id-'; ordena los items de por ID de forma descendente.
     *
     * @param Builder  $searchModel builder donde de implementara el ordenamiento
     * @param string   $order       attributo a ordenar
     * @param Eloquent $model       model
     * @return Builder
     */
    protected function setOrder($searchModel, $order, $model = false)
    {
        if (! $model) {
            $model = new $this->model;
        }

        if (empty($order) and $this->default_order) {
            $order = $this->default_order;
        }

        if ($model->hasColumn(str_replace('-', '', $order))) {
            if (strpos($order, '.') !== false) {
                $order = explode('.', $order);

                $searchModel->with(\str_replace('-', '', $order['0']));

                if (strpos($order['0'], '-') !== false) {
                    $order = '-'.$order[1];
                } else {
                    $order = $order[1];
                }
            }

            if (strpos($order, '-') !== false) {
                $this->filters['order'] = $order;

                return $searchModel->orderBy(str_replace('-', '', $order), 'DESC');
            } else {
                $this->filters['order'] = '-'.$order;

                return $searchModel->orderBy($order, 'ASC');
            }
        }

        return $searchModel;
    }

    /**
     * Add the necessary filters to the query builder.
     *
     * @param Builder $models  builder on which the filters will be added
     * @param Request $request user's request
     * @return Builder
     */
    protected function setFilter($models, Request $request)
    {
        $model = new $this->model();

        $params = $request->all();

        foreach ($this->ignore as $key => $value) {
            unset($params[$value]);
        }

        if ($params) {
            foreach ($params as $parameter => $value) {
                if (! empty($value)) {
                    $table = $model->getTable();
                    $parameter = str_replace('-', ' ', $parameter);
                    $filter = $model->hasFilter($parameter);

                    if ($filter) {
                        if (isset($filter['join'])) {
                            if (\is_array($model->filters[$parameter]['join'])) {
                                $table = $model->filters[$parameter]['join']['table'];
                            } else {
                                $table = Str::plural($parameter);
                            }
                            $models = $models->join(
                                $table,
                                $model->filters[$parameter]['join']['local_key'] ?? Str::singular($table).'_id',
                                '=',
                                $model->filters[$parameter]['join']['foreign_key'] ?? $table.'.id'
                            );
                        }

                        if (\is_array($filter['column'] ?? false)) {
                            $models = $models->where(function ($query) use ($model, $value, $parameter) {
                                foreach ($model->filters[$parameter]['column'] as $colum) {
                                    $query->orWhere($colum, 'like', '%'.$value.'%');
                                }
                            });
                        } else {
                            switch ($filter['type'] ?? 'like') {
                                case 'like':
                                    $models = $models->where($table.'.'.
                                    ($filter['column'] ?? $filter), 'like', '%'.$value.'%');
                                    break;
                                case 'equal':
                                    $models = $models->where($table.'.'.
                                    ($filter['column'] ?? (is_array($filter) ? $parameter : $filter)), '=', $value);
                                    break;
                                case 'date_less':
                                    $models = $models->whereDate($table.'.'.
                                    ($filter['column'] ?? (is_array($filter) ? $parameter : $filter)), '>=', $value);
                                    break;
                                case 'date_higher':
                                    $models = $models->whereDate($table.'.'.
                                    ($filter['column'] ?? (is_array($filter) ? $parameter : $filter)), '<=', $value);
                                    break;
                            }
                        }
                    }
                }
                $this->filters[$parameter] = $value;
            }
        }

        return $models;
    }

    protected function getModel($id, $attribute = null)
    {
        $model = new $this->model();
        $model = $this->getDefaultStatus($model);
        $model = $model->where($attribute ?? $this->model::$keyId, $id);

        return $model->first();
    }

    /**
     * Encuentra un modelo o devuelve un 404
     *
     * @param  int  $id
     */
    protected function findModel($id, $attribute = null)
    {
        $model = $this->getModel($id, $attribute);

        if (!$model) {
            abort(404);
        }

        return $model;
    }

    protected function filterResources(Request $request, $model)
    {
        $status = $request->input('status');

        if ($status || $status == '0') {
            $models = $this->model::where($model->getTable().'.status', $status);
        } else {
            $models = $this->getDefaultStatus($model);
        }

        $models = $this->with($models);
        $models = self::setOrder($models, $request->get('order'));

        if ($request->input('pagination')) {
            $this->filters['pagination'] = $request->input('pagination');
        }

        $models = self::setFilter($models, $request);
        return $models->paginate($this->filters['pagination'])->appends($this->filters);
    }
}
