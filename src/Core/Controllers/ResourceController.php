<?php

namespace Sdkconsultoria\Base\Core\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sdkconsultoria\Base\Core\Controllers\Traits\ApiControllerTrait;
use Sdkconsultoria\Base\Core\Controllers\Traits\ResourceControllerTrait;

class ResourceController extends Controller
{
    use ApiControllerTrait;
    use ResourceControllerTrait;

    protected $model = '';
}
