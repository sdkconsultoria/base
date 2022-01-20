<?php

namespace Sdkconsultoria\Base\Core\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Str;

/**
 * Permite crear REST API rapidamente
 */
trait SearchableControllerTrait
{
    private function searchable($query, Request $request)
    {
        $filters =  $this->model::getFilters();
        $parameters =  $request->all();

        // for ($i=0; $i < count($filters); $i++) {
        //
        //     dump($filters[$i]);
        // }
        // dd('GG');
        foreach ($filters as $key => $value) {
            $filter_columns = $this->getFilterAttribute($key, $value);

            if ($this->isValidForSearch('$filter_columns')) {
                // code...
            }

            $filter_type = $this->getFilterType($key, $value);
            dump($filter_type);
        }
        dd('GG');
    }

    private function getFilterAttribute($key, $value)
    {
        if (is_numeric($key)) {
            return $value;
        }

        if (! is_array($value)) {
            return $key;
        }

        $column = $value['column'] ?? false;

        if ($column) {
            return $column;
        }

        return $key;
    }

    private function isValidForSearch(string $searchable_name) : bool
    {
        return true;
    }

    private function getFilterType($key, $value)
    {
        if (is_numeric($key)) {
            return 'like';
        }

        if (! is_array($value)) {
            return $value;
        }

        $type = $value['type'] ?? false;

        if ($type) {
            return $type;
        }

        return 'like';
    }

    private function searchaByLike()
    {

    }

    private function searchaByEquals()
    {

    }

    private function searchaByBetween()
    {

    }
}
