<?php

namespace Sdkconsultoria\Base\Core\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Str;

/**
 * Permite crear REST API rapidamente
 */
trait OrderableTrait
{
    private function applyOrderByToQuery($query, $order)
    {
        if ($order) {
            $parsed_order = $this->parseOrderToValueAndType($order);
            $query = $query->orderBy($parsed_order['value'], $parsed_order['type']);
        }

        return $query;
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
