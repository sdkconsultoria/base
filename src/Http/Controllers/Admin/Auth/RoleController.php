<?php

namespace Sdkconsultoria\Base\Http\Controllers\Admin\Auth;

use Sdkconsultoria\Core\Controllers\ResourceController;

class RoleController extends ResourceController
{
    protected $model = \Sdkconsultoria\RoleManager\Models\Role::class;
}
