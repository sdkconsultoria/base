<?php
namespace Sdkconsultoria\Base\Helpers\Html\Grid;

use Sdkconsultoria\Base\Helpers\Html\BaseHtml;
use Sdkconsultoria\Base\Helpers\Html\iHtml;
use Base;

/**
 *
 */
class ActionColumn extends BaseHtml implements iHtml
{
    protected $model;
    protected $html = '';
    protected $key;

    function __construct($model, array $params = [])
    {
        $this->model = $model;
        $this->key = $this->model->getKeyId();
        $this->makeDelete();
        $this->makeEdit();
        $this->makeShow();
    }

    public static function make(array $params)
    {
        $object = new self($params);

        return $object;
    }


    protected function makeDelete()
    {
        $this->html .= '
            <form
            data-title="' . $this->model::getTranslate('delete_question') . '"
            data-confirm="' . $this->model::getTranslate('delete') . '"
            data-cancel="' . __('base::app.common.cancel') . '"
            class="form-question" method="POST" action="' . $this->model::getRoute('destroy', $this->key) . '">
                <input type="hidden" name="_token" value="' . csrf_token() . '" />
                <input type="hidden" name="_method" value="DELETE">
                <button class="h-5 w-5 mr-1" type="submit"> ' . Base::icon('trash') . '</button>
            </form>
        ';
    }

    protected function makeEdit()
    {
        $this->html .= '
            <a class="h-5 w-5 mr-1" href="' . $this->model::getRoute('edit', $this->key) . '" > ' . Base::icon('pencil') . '</a>
        ';
    }

    protected function makeShow()
    {
        $this->html .= '
            <a class="h-5 w-5 mr-1" href="' . $this->model::getRoute('show', $this->key) . '" > ' . Base::icon('eye') . '</a>
        ';
    }

    public function render()
    {
        return '
            <div class="flex flex-row">
                ' . $this->html . '
            </div>
        ';
    }
}
