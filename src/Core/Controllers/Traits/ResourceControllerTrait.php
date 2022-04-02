<?php

namespace Sdkconsultoria\Base\Core\Controllers\Traits;

use Illuminate\Http\Request;

trait ResourceControllerTrait
{
    public function index(Request $request)
    {
        $model = new $this->model;
        $model->isAuthorize('viewAny');

        return view($this->view . '.index', [
            'model' => $model
        ]);
    }

    public function create(Request $request, $id)
    {

    }

    public function edit(Request $request)
    {

    }

    public function show(Request $request, $id)
    {

    }
}
