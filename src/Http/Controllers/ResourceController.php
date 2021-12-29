<?php

namespace Sdkconsultoria\Base\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sdkconsultoria\Base\Traits\ControllerTrait;

class ResourceController extends Controller
{
    use ControllerTrait;

    /**
     * Ignora los siguientes parametros de los filtros
     * @var array
     */
    protected $ignore = ['page', 'pagination', 'order'];

    /**
     * Determine the default filters, the default pagination is 50 elements per page.
     * @var array
     */
    protected $filters = ['pagination' => '10'];

    protected $create_empty = false;

    protected $default_template = true;

    /**
     * Determina el orden por defecto de los modelos
     * Ejemplo:
     * protected $default_order = 'id'; ordena los items de por ID de forma ascendente.
     * protected $default_order = 'id-'; ordena los items de por ID de forma descendente.
     * @var string
     */
    protected $default_order = false;

    public function index(Request $request)
    {
        $model = new $this->model();

        return view($this->view . 'index', [
            'models' => $this->filterResources($request, $model),
            'model' => $model,
        ]);
    }

    /**
     * Muestra un formulario para crear un recurso.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($this->create_empty) {
            $model = $this->createOrFind();
        } else {
            $model = new $this->model();
        }

        return view(($this->default_template ? 'base::default.' : $this->view ). 'create', [
            'model' => $model,
            'view' => $this->view
        ]);
    }

    /**
     * Muestra un formulario para actualizar un recurso.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view(($this->default_template ? 'base::default.' : $this->view ) . '.edit', [
            'model' => $this->findModel($id),
            'view' => $this->view
        ]);
    }

    /**
     * Elimina un recurso.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = $this->findModel($id);
        $model->status = $this->model::STATUS_DELETED;
        $model->deleted_at = date('Y-m-d H:i:s');
        $model->save();

        return redirect($model->getRoute('index'))->with('toast', [
            'type' => 'success',
            'text' => $this->model::getTranslate('deleted'),
        ]);
    }

    /**
     * Guarda un modelo
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->model::rules($request));

        $model = $this->createOrFind();
        $model->status = $this->model::STATUS_ACTIVE;
        $this->loadData($model, $request);
        $model->created_by = \Auth::user()->id;
        $model->save();

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
        $this->validate($request, $this->model::updateRules($request));

        $model = $this->findModel($id);
        $this->loadData($model, $request);
        $model->updated_by = \Auth::user()->id;
        $model->save();

        return redirect($model->getRoute('index'))->with('toast', [
            'type' => 'success',
            'text' => $this->model::getTranslate('edited'),
        ]);
    }

    /**
     * Muestra un modelo.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view($this->view . 'show', [
            'model' => $this->findModel($id)
        ]);
    }
}
