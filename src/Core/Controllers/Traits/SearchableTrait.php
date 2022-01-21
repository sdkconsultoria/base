<?php

namespace Sdkconsultoria\Base\Core\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Str;

/**
 * Permite crear REST API rapidamente
 */
trait SearchableTrait
{
    private function searchable($query, Request $request)
    {
        $filters =  $this->model::getFilters();
        $parameters =  $request->all();

        foreach ($filters as $key => $value) {
            $parse_options = $this->parseFilterOptions($key, $value);
            $parse_options['filter_value'] = $request->input($parse_options['name']);

            if ($parse_options['filter_value']) {
                $query = $this->applyFilterToQuery($query, $parse_options);
            }
        }

        return $query;
    }

    private function parseFilterOptions($key, $value) : array
    {
        $options = [
            'name' => null,
            'column' => null,
            'type' => null,
            'relation' => null,
        ];

        if (is_numeric($key)) {
            $options['name'] = $value;
            $options['type'] = $this->model::DEFAULT_SEARCH;
            $options['column'] = $value;
            $options['relation'] = null;

            return $options;
        }

        if (! is_array($value)) {
            $options['name'] = $key;
            $options['type'] = $value;
            $options['column'] = $key;
            $options['relation'] = null;

            return $options;
        }

        $options['name'] = $key;
        $options['type'] = $value['type'] ?? $this->model::DEFAULT_SEARCH;
        $options['column'] = $value['column'] ?? $key;
        $options['relation'] = $value['relation'] ?? false;

        return $options;
    }

    private function applyFilterToQuery($query, $parse_options)
    {
        switch ($parse_options['type']) {
            case 'like':
                $query = $query->where($parse_options['column'], 'like', "%{$parse_options['filter_value']}%");
                break;

            case 'equals':
                $query = $query->where($parse_options['column'], $parse_options['filter_value']);
                break;

            default:
                // code...
                break;
        }

        return $query;
    }
}
