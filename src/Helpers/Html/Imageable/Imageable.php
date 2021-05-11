<?php

namespace Sdkconsultoria\Base\Helpers\Html\Imageable;

use Sdkconsultoria\Base\Helpers\Html\BaseHtml;
use Sdkconsultoria\Base\Helpers\Html\iHtml;
use Sdkconsultoria\Base\Models\Common\Image\Image;

/**
 *
 */
class Imageable extends BaseHtml implements iHtml
{
    protected $images;
    public $table;
    public $openType;

    public static function make(array $options = [])
    {
        $object = new self;
        $object->images = $options['images'];
        $object->table = $options['table'];
        $object->openType = $options['openType'] ?? false;
        return $object;
    }


    public function render()
    {
        return $this->table();
    }

    public function row($value)
    {
        return '
            <tr id="' . $this->table . '_row_' . $value->id . '">
                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-center" >' . $value->id . '</td>
                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-center" >' . $value->imagePreview('thumbnail', 'large', ['class' => 'inline']) . '</td>
                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-center" >' . ($this->openType ? Text::make($value) : Select::make($value) ) . '</td>
                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-center" >' . Menu::make($value) . '</td>
            </tr>
        ';
    }

    protected function rows()
    {
        $rows = '';

        foreach ($this->images as $key => $value) {
             $rows .= $this->row($value);
        }

        return $rows;
    }

    protected function table()
    {
        if ($this->images) {
            return '
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table id="' . $this->table . '_imageable" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th>' . Image::getLabel('id') . '</th>
                                <th>' . Image::getLabel('image') . '</th>
                                <th>' . Image::getLabel('type') . '</th>
                                <th>' . Image::getLabel('menu') . '</th>
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
