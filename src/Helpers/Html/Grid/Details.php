<?php
namespace Sdkconsultoria\Base\Helpers\Html\Grid;

use Sdkconsultoria\Base\Helpers\Html\BaseHtml;
use Sdkconsultoria\Base\Helpers\Html\iHtml;

/**
 *
 */
class Details extends BaseHtml implements iHtml
{
    public $model;
    public $attributes;

    public static function make(array $params)
    {
        $object = new self($params);
        $object->model = $params['model'];
        $object->attributes = $params['attributes'];

        return $object;
    }

    protected function body()
    {
        $html = '';

        foreach ($this->attributes as $attribute) {
            $html .= '<tr>';
            $html .= '<th class="text-gray-700">' .  $this->model->getLabel($attribute) . '</th>';
            $html .= '<td>' . $this->getValue($attribute) . '</td>';
            $html .= '</tr>';
        }

        return $html;
    }

    private function getValue(string $attribute)
    {
        if (str_contains($attribute, '.')) {
            $explode = explode('.', $attribute);
            return $this->model->{$explode[0]}->{$explode[1]};
        }

        return $this->model->$attribute;
    }

    public function render()
    {
        return '
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <tbody class="bg-white divide-y divide-gray-200">
                            ' . $this->body() . '
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        ';
    }
}
