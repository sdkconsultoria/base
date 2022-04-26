<?php

namespace Sdkconsultoria\Base;

/**
 *
 */
class Base
{
    public function popUp(array $options = [])
    {
        return \Sdkconsultoria\Base\Helpers\Html\PopUp::make($options);
    }

    public function popUpFinish(array $options = [])
    {
        return \Sdkconsultoria\Base\Helpers\Html\PopUp::finish();
    }

    public function icon(string $icon, array $optionsHtml = [], string $type = 'outline')
    {
        return new \Sdkconsultoria\Base\Helpers\Html\Icon($icon, $optionsHtml, $type);
    }

    public function settings($model)
    {
        return new \Sdkconsultoria\Base\Helpers\Html\Setting($model);
    }

    public function img(string $rute, array $optionsHtml = [])
    {
        return new \Sdkconsultoria\Base\Helpers\Html\Img($rute, $optionsHtml);
    }

    public function input(array $options = [])
    {
        return \Sdkconsultoria\Base\Helpers\Html\Input::make($options);
    }

    public function alert(array $options = [])
    {
        return \Sdkconsultoria\Base\Helpers\Html\Alert::make($options);
    }

    public function toast(array $options = [])
    {
        return \Sdkconsultoria\Base\Helpers\Html\Toast::make($options);
    }

    public function menu(array $options = [])
    {
        return \Sdkconsultoria\Base\Helpers\Html\Menu::make($options);
    }

    public function gridView(array $options = [])
    {
        return \Sdkconsultoria\Base\Helpers\Html\Grid\GridView::make($options);
    }

    public function details(array $options = [])
    {
        return \Sdkconsultoria\Base\Helpers\Html\Grid\Details::make($options);
    }

    public function breadcrumb(array $options = [])
    {
        return \Sdkconsultoria\Base\Helpers\Html\Breadcrumb::make($options);
    }

    public function imageable(array $options = [])
    {
        return \Sdkconsultoria\Base\Helpers\Html\Imageable\Imageable::make($options);
    }

    public function taggeable(array $options = [])
    {
        return \Sdkconsultoria\Base\Helpers\Html\Taggeable\Taggeable::make($options);
    }

    public function languages()
    {
        return collect(config('base.languages'))->map(function ($lang) {
            return __('core::languages.' . $lang[0]);
        })->toArray();
    }

    public function imagesGroup($identifier, $type = '')
    {
        $model = \Sdkconsultoria\Base\Models\Common\Image\ImageGroup::where('identifier', $identifier)->first();

        if ($type) {
            return $model->translate->images->where('type', $type)->first();
        }

        return $model->translate->images->all();
    }
}
