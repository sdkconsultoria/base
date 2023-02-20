<?php

namespace Sdkconsultoria\Base\Helpers\Html;

class Icon extends BaseHtml
{
    private $icon = '';

    private $type = '';

    private $options = ['class' => 'text-gray-500 fill-black', 'stroke'=>'#fff'];

    public function __construct(string $icon, array $options = [], string $type = 'outline')
    {
        $this->icon = $icon;
        $this->type = $type;
        $this->options = self::setAttributes(array_merge($this->options, $options));
    }

    public static function generate($icon)
    {
        return new self($icon);
    }

    private function parseIcon(string $icon)
    {
        $icon = str_replace('<svg ', '<svg '.$this->options, $icon);
        return str_replace('stroke="#0F172A"', 'stroke="currentColor"', $icon);
    }

    public function render(): string
    {
        $path = dirname(__DIR__).'/../../resources/icons/'.$this->type.'/'.$this->icon.'.svg';

        try {
            return $this->parseIcon(file_get_contents($path));
        } catch (\Exception $e) {
            return '';
        }
    }
}
