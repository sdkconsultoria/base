<?php

namespace Sdkconsultoria\Base\Http\Controllers\Admin;

use Sdkconsultoria\Core\Controllers\ResourceController;
use Illuminate\Http\Request;

class UserController extends ResourceController
{
    protected $model = \App\Models\User::class;

    // /**
    //  * Muestra un formulario para actualizar mi cuenta
    //  * @return view
    //  */
    // public function myAccount()
    // {
    //     $model = auth()->user();

    //     return view($this->view . 'my_account', [
    //         'model' => $model,
    //         'images' => $model->images,
    //     ]);
    // }

    // public function createToken(Request $request)
    // {
    //     $token = auth()->user()->createToken($request->input('name'))->plainTextToken;
    //     $request->session()->flash('sactum_token', __('base::models.token.created', ['token' => $token]));

    //     return redirect()->route('my_account');
    // }

    // public function deleteToken(string $id)
    // {
    //     auth()->user()->tokens()->where('id', $id)->delete();
    //     request()->session()->flash('sactum_token', trans_choice('base::models.common.deleted', 1, ['item' => 'Token']));

    //     return redirect()->route('my_account');
    // }

    // /**
    //  * Actualiza los datos del usuario actual
    //  * @param  Request $reques
    //  * @return redirect
    //  */
    // public function saveAccount(Request $request)
    // {
    //     $model = auth()->user();

    //     $this->validate($request, $this->model::accountRules($request));
    //     $this->loadData($model, $request);

    //     if ($request->password) {
    //         $model->password = HashHash::make($request->password);
    //     }

    //     $model->save();

    //     return redirect()->route('my_account')->with('toast', [
    //         'type' => 'success',
    //         'text' => $this->model::getTranslate('edited'),
    //     ]);
    // }
}
