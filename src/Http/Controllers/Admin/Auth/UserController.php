<?php

namespace Sdkconsultoria\Base\Http\Controllers\Admin\Auth;

use Sdkconsultoria\Core\Controllers\ResourceController;

class UserController extends ResourceController
{
    protected $model = \App\Models\User::class;

    public function myAccount()
    {
        return view('base::back.users.my_account', [
            'model' => auth()->user()
        ]);
    }
}
