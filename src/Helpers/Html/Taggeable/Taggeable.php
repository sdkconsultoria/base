<?php

namespace Sdkconsultoria\Base\Helpers\Html\Taggeable;

use Sdkconsultoria\Base\Helpers\Html\BaseHtml;
use Sdkconsultoria\Base\Helpers\Html\iHtml;
use Sdkconsultoria\Base\Models\Common\Tag\Tag;

/**
 *
 */
class Taggeable extends BaseHtml implements iHtml
{
    protected $tags;
    public $model;

    public static function make(array $options = [])
    {
        $object = new self;
        $object->tags = $options['tags'];
        $object->model = $options['model'];
        return $object;
    }


    public function render()
    {
        return $this->table();
    }

    public function row($value)
    {
        return '
            <tr id="' . $this->model->getTable() . '_row_' . $value->id . '">
                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-center" >' . $value->id . '</td>
                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-center" >' . $value->translate->name . '</td>
                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-center" >' . Menu::make($value, $this->model) . '</td>
            </tr>
        ';
    }

    protected function rows()
    {
        $rows = '';

        foreach ($this->tags as $key => $value) {
             $rows .= $this->row($value);
        }

        return $rows;
    }

    protected function table()
    {
        if ($this->tags) {
            return '
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table id="' . $this->model->getTable() . '_taggeable" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th>' . Tag::getLabel('id') . '</th>
                                <th>' . Tag::getLabel('singular') . '</th>
                                <th>' . Tag::getLabel('menu') . '</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        ' . $this->rows() . '
                        </tbody>
                    </table>
                </div>';
        }

        return '';
    }
}
