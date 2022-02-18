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
            $parsed_options = $this->parseFilterOptions($key, $value);
            $parsed_options['filter_value'] = $request->input($parsed_options['name']);

            if ($parsed_options['filter_value']) {
                $this->applyFilters($query, $parsed_options);
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

    private function applyFilters($query, $parsed_options)
    {
        if (is_array($parsed_options['column'])) {
            $query->where(function($query) use ($parsed_options) {
                foreach ($parsed_options['column'] as $column) {
                    $query->orWhere($column, 'like', "%{$parsed_options['filter_value']}%");
                }
            });
        } else {
            $this->applyFilterToQuery($query, $parsed_options);
        }

        return $query;
    }

    private function applyFilterToQuery(&$query, $parsed_options)
    {

        switch ($parsed_options['type']) {
            case 'equals':
                $query->where($parsed_options['column'], $parsed_options['filter_value']);
                break;
            case 'like':
            default:
            // dump($parsed_options);
                $query->where($parsed_options['column'], 'like', "%{$parsed_options['filter_value']}%");
                break;
        }
    }
}
