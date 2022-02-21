<?php

namespace Sdkconsultoria\Base\Core\Controllers\Traits;

use Illuminate\Http\Request;

trait PaginationTrait
{
    protected function setPagination($query, Request $request)
    {
        return $query->paginate(2);
    }
}
