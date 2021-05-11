<?php
namespace Sdkconsultoria\Base\Helpers\Html\Grid;

use Request;
use Base;
use Illuminate\Support\Facades\URL;
use Sdkconsultoria\Base\Helpers\Html\BaseHtml;
use Sdkconsultoria\Base\Helpers\Html\iHtml;

/**
 *
 */
class GridView extends BaseHtml implements iHtml
{
    protected $models;
    protected $model;
    protected $attributes;
    protected $order;
    protected $url;
    protected $params;

    function __construct(array $params)
    {
        $this->models = $params['models'];
        $this->model = $params['model'];
        $this->attributes = $params['attributes'];
        $this->order = $_GET['order'] ?? false;
        $this->url = URL::current() . '?';
        $this->params = Request::all();
        unset($this->params['order']);

        foreach ($this->params as $key => $value) {
            $this->url .= $key . '=' . $value . '&';
        }

        $this->url .= 'order=';

    }

    public static function make(array $params)
    {
        $object = new self($params);

        return $object;
    }

    protected function body()
    {
        $html = '';

        foreach ($this->models as $model) {
            $html .= '<tr>';
            foreach ($this->attributes as $attribute) {
                $value = $this->getRealValue($model, $attribute);
                $html .= $this->item($value);
            }
            $html .= $this->getActionColumn($model);
            $html .= '</tr>';
        }

        return $html;
    }

    protected function getActionColumn($model)
    {
        return '
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            ' . new ActionColumn($model) . '
        </td>';
    }

    public function render()
    {
        return $this->tableWrapper();
    }

    protected function tableWrapper()
    {
        return new SearchForm($this->model) . '
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                ' . $this->header() . '
                                <th></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            ' . $this->body() . '
                            </tbody>
                        </table>
                        ' . $this->models->links() . '
                    </div>
                </div>
            </div>
        </div>';
    }

    protected function header()
    {
        $html = '';

        foreach ($this->attributes as $attribute) {
            $value = $this->getAttributeValue($attribute);

            $html .= '
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                ' . $value . '
            </th>';
        }

        return $html;
    }
    protected function getRealValue($model, $attribute)
    {
        if (str_contains($attribute, '.')) {
            $explode = explode('.', $attribute);
            return $model->{$explode[0]}->{$explode[1]};
        }

        if (is_array($attribute)) {
            return $attribute['value']($model);
        }

        return $model->$attribute;
    }

    protected function item($value)
    {
        return '
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            ' . ($value ?? '---'). '
        </td>';
    }


    protected function getAttributeValue($attribute)
    {
        if (is_array($attribute)) {
            if ($attribute['raw_name'] ?? false) {
                return $attribute['raw_name'];
            }

            if ($attribute['name'] ?? false) {
                return $this->model::getLabel($attribute['name']);
            }

            $attribute = $attribute['attribute'];
        }

        return $this->isSort($attribute);
    }

    protected function isSort($attribute)
    {
        $order = str_replace('-', '', $this->order);
        $icon = '';

        $is_desc = strpos( $this->order, '-' ) !== false;

        if ($attribute == $order) {
            if ($is_desc) {
                $icon = Base::icon('chevron-up', ['class' => 'h-5 ml-2']);
            } else {
                $icon = Base::icon('chevron-down', ['class' => 'h-5 ml-2']);
                $this->url .= '-';
            }
        }

        return '<a href="' . $this->url . $attribute . '" class="flex flex-row items-center text-cyan-600 font-bold	" >' . $this->model::getLabel($attribute) . ' ' . $icon . '</a>';
    }
}
