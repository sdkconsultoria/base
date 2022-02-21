<?php

namespace Sdkconsultoria\Base\Core\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Str;

trait OrderableTrait
{
    private function applyOrderByToQuery($query, $order)
    {
        if ($this->isValidForOrder($order)) {
            $parsed_order = $this->parseOrderToValueAndType($order);
            $query = $query->orderBy($parsed_order['value'], $parsed_order['type']);
        }

        return $query;
    }

    private function isValidForOrder($order)
    {
        if (!$order) {
            return false;
        }

        $model =  new $this->model;

        return $model->hasColumn(str_replace('-', '', $order));
    }

    private function parseOrderToValueAndType($order)
    {
        if (str_starts_with($order, '-')) {
            return [
                'value' => str_replace('-', '', $order),
                'type' => 'desc',
            ];
        }

        return [
            'value' => $order,
            'type' => 'asc',
        ];
    }
}
