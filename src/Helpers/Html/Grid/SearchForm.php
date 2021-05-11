<?php
namespace Sdkconsultoria\Base\Helpers\Html\Grid;

use Sdkconsultoria\Base\Helpers\Html\BaseHtml;
use Sdkconsultoria\Base\Helpers\Html\iHtml;
use Illuminate\Support\Facades\URL;
use Request;
use Base;

/**
 *
 */
class SearchForm extends BaseHtml implements iHtml
{
    public $params;
    public $model;

    function __construct($model)
    {
        $this->model = $model;
        $this->params = Request::all();
        unset($this->params['page']);
        unset($this->params['pagination']);
    }

    protected function wrapper()
    {
        $html = '
        <div x-data="{ open: '. ($this->params?'true':'false') . ' }">
            <button x-on:click="open = !open" type="button" class="btn btn-warning mb-2 flex flex-row items-center">
                ' .  __('base::app.grid.advanced_search') .'
                ' . Base::icon('chevron-right', ['class' => 'h-5 ml-3', 'x-show' => '!open']) .'
                ' . Base::icon('chevron-up', ['class' => 'h-5 ml-3', 'x-show' => 'open']) . '
            </button>
            <form id="search-form" x-show="open" class="flex flex-row flex-wrap" action="" method="get">
                <input type="hidden" name="order" value="' . ($_GET['order']  ?? '') . '">
                 ' . $this->forms() . '
                <div class="w-full flex flex-row justify-end">
                    <a href="' . URL::current() . '" class="items-center text-sm rounded-l-lg shadow-md text-gray-700 p-1 bg-yellow-300 mb-2 flex flex-row" type="button">
                        ' . Base::icon('refresh', ['class' => 'h-4 mr-1']) . ' ' . __('base::app.grid.clear')  . '
                    </a>
                    <button class="items-center text-sm rounded-r-lg shadow-md text-gray-700 p-1 bg-blue-300 mb-2 flex flex-row" type="submit">
                        ' . Base::icon('document-search', ['class' => 'h-4 mr-1']) . ' ' . __('base::app.grid.search') . '
                    </button>
                </div>
            </form>
        </div>
        ';

        return $html;
    }

    protected function forms()
    {
        $html = '';

        foreach ($this->model->filters as $key => $filter) {
            $is_array = is_array($filter);
            $name = $is_array ? $key : $filter;
            $input = Base::input([
                 'name' => $name,
                 'value' => $this->params[$name] ?? '',
            ])->setTranslate($this->model->getLabel($name));

            if ($is_array ) {
                switch ($filter['type'] ?? '') {
                    case 'dropdown':
                        $input = $input->dropDown($this->model->getStatus(), [], 'base::app.common.search_by');
                    break;

                    default:
                    // code...
                    break;
                }
            }

            $input = $input->wrap(true, ['class' => 'form-group w-full md:w-1/4 pr-1']);
            $html .= $input;
        }

        return $html;
    }

    public function render()
    {
        return $this->wrapper();
    }
}
