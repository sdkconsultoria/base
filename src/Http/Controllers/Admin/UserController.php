<?php

namespace Sdkconsultoria\Base\Http\Controllers\Admin;

use Sdkconsultoria\Base\Http\Controllers\ResourceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends ResourceController
{
    protected $model = \App\Models\User::class;
    protected $view = 'base::back.users.';

    /**
     * Muestra un formulario para actualizar mi cuenta
     * @return view
     */
    public function myAccount()
    {
        $model = auth()->user();

        return view($this->view . 'my_account', [
            'model' => $model,
            'images' => $model->images,
        ]);
    }

    /**
     * Actualiza los datos del usuario actual
     * @param  Request $reques
     * @return redirect
     */
    public function saveAccount(Request $request)
    {
        $model = auth()->user();

        $this->validate($request, $this->model::accountRules($request));
        $this->loadData($model, $request);

        if ($request->password) {
            $model->password = HashHash::make($request->password);
        }

        $model->save();

        return redirect()->route('my_account')->with('toast', [
            'type' => 'success',
            'text' => $this->model::getTranslate('edited'),
        ]);
    }
}
