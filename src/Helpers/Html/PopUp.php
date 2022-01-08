<?php

namespace Sdkconsultoria\Base\Helpers\Html;

use Base;

/**
 *
 */
class PopUp extends BaseHtml implements iHtml
{
    private $id;

    function __construct(array $options)
    {
        // $this->items = $items;
    }

    public static function make(array $options)
    {
        $model = new self($options);
        $model->id = $options['id'] ?? 'id';

        return $model;
    }

    public static function finish()
    {
        return '
                    </div>
                </div>
            </div>
        </div>';
    }

    /**
     * Convierte esta clase a un html valido
     * @return string
     */
    public function render()
    {
        $html = '
        <div x-show="' . $this->id . '"  class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-on:click="' . $this->id . ' = false"  class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle md:w-6/12 sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">';

        return $html;
    }
}
