<?php

namespace Sdkconsultoria\Base\Helpers\Html;

/**
 *
 */
class Alert extends BaseHtml implements iHtml
{
    private $html = '';
    private $background = '';
    private $icon = '';

    public static function make(array $options = [])
    {
        return new self();
    }

    public function header(string $header)
    {
        $this->html .= ' <p class="font-bold">' . $header . '</p>';
        return $this;
    }

    public function icon()
    {
        $this->html .=
        '<span class="absolute inset-y-0 right-0 flex items-center mr-4">
            <svg class="w-4 h-4 fill-current" role="button" viewBox="0 0 20 20"><path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
         </span>';
        return $this;
    }

    public function success(string $text)
    {
        $this->html .= '<p>' . $text . '</p>';
        $this->background = ' text-green-700 bg-green-100';
        return $this;
    }

    public function danger(string $text)
    {
        $this->html .= '<p>' . $text . '</p>';
        $this->background = ' text-red-700 bg-red-100';
        return $this;
    }

    public function warning(string $text)
    {
        $this->html .= '<p>' . $text . '</p>';
        $this->background = ' text-yellow-700 bg-yellow-100';
        return $this;
    }

    public function primary(string $text)
    {
        $this->html .= '<p>' . $text . '</p>';
        $this->background = ' text-blue-700 bg-blue-100';
        return $this;
    }

    public function render()
    {
        return
        '<div class="px-4 py-3 leading-normal ' . $this->background . ' rounded-lg" role="alert">
           ' . $this->html . '
        </div>';
    }

}
