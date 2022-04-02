<?php

namespace Sdkconsultoria\Base\Core\Controllers\Traits;

use Illuminate\Http\Request;

trait PaginationTrait
{
    protected $pagination = 10;

    protected function setPagination($query, Request $request)
    {
        $pages = $this->getElementsPerPage($request);

        return $query->paginate($pages)->appends($request->all());
    }

    protected function getElementsPerPage(Request $request)
    {
        return $request->pagination ?? $this->pagination;
    }
}
