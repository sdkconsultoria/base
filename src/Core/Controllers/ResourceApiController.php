<?php

namespace Sdkconsultoria\Base\Core\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sdkconsultoria\Base\Core\Controllers\Traits\ApiControllerTrait;

class ResourceApiController extends Controller
{
    use ApiControllerTrait;

    protected $mode = '';
}
