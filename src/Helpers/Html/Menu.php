<?php

namespace Sdkconsultoria\Base\Helpers\Html;

use Route;
use Base;

/**
 *
 */
class Menu extends BaseHtml implements iHtml
{
    protected $item_class = 'flex items-center mt-4 py-2 px-6 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100';
    protected $sub_item_class = 'ml-4 flex items-center mt-1 py-2 px-6 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100';
    protected $active_class = 'bg-gray-700 bg-opacity-25 text-gray-100';
    protected $purge_class = 'text-gray-500';
    protected $current_route;
    protected $items;
    protected $urls;
    protected $is_active = false;

    function __construct(array $items)
    {
        $this->items = $items;
        $this->current_route = Route::currentRouteName();
    }

    public static function make(array $items)
    {
        $sidebar = new self($items);

        return $sidebar;
    }

    /**
     * Determina si el item actual esta activo o no
     * Determina que clases son necesarias
     * Si es un sub item agrega padding izquierdo
     * @return string las clases que se deben agregar al elemento
     */
    protected function isActive(int $level = 0, $urls = [], $last_active = false){
        $class = $this->item_class;
        $is_active = false;

        if (in_array($this->current_route, $urls) || $last_active) {
            $class = str_replace($this->purge_class, '', $class);
            $class .= $this->active_class;
            $is_active = true;
        }

        if ($level) {
            $class .= ' ml-' . ($level * 5) . ' ';
        }

        return [$class, $is_active];
    }

    /**
     * Obtiene la ruta de un item
     * @param  array   $item
     * @return string  ruta
     */
    protected function getRoute(array $item)
    {
        $route = $item['url'] ?? '#';

        if (is_array($route)) {
            return route($route[0], $route[1]);
        }

        if ($route == '#') {
            return '#';
        }

        if (substr( $route, 0, 1) === '#' || substr( $route, 0, 4) === 'http') {
            return $route;
        }

        return route($route);
    }

    /**
     * Convierte esta clase a un html valido
     * @return string
     */
    public function render()
    {
        $html = '';

        foreach ($this->items as $item) {
            if ($item['visible'] ?? true) {
                $html .= $this->writteItem($item)[0];
            }
        }

        return $html;
    }

    protected function writteItem(array $item, $level = 0)
    {
        $urls = $this->getUrls($item);
        $items = $this->getItems($item, $level + 1);
        $is_active = $this->isActive($level, $urls, $items[1]);
        $html = '
        <div ' . ($items?'x-data="{ open: ' . ($is_active[1]?'true':'false') . ' }"':'') . '>
            <a  '.($items?'x-on:click="open = !open"':'').' class="' . $is_active[0] . '" href="' . $this->getRoute($item) . '">
                ' . ($item['icon'] ?? '') . '
                <span class="mx-3">' . $item['name'] . '</span>
                ' . $this->getDrowpdownIcon($items[0]) . '

            </a>' . $items[0] . '
        </div>';

        return [
            $html,
            $is_active[1]
        ];
    }

    protected function getItems(array $item, $level)
    {
        $html = '';
        $is_active = false;
        if ($item['items'] ?? []) {
            $html .= '<div x-show="open" >';
            foreach ($item['items'] as $item) {
                $content = $this->writteItem($item, $level);
                $html .= $content[0];
                if ($content[1]) {
                    $is_active = true;
                }
            }
            $html .= '</div>';
        }

        return [$html, $is_active];
    }

    protected function getDrowpdownIcon($items)
    {
        $icon = '';
        if ($items) {
            $icon .= Base::icon('chevron-right', ['class' => 'h-6 w-6 ml-auto', 'x-show' => '!open']) ;
            $icon .= Base::icon('chevron-up', ['class' => 'h-6 w-6 ml-auto', 'x-show' => 'open']) ;
        }
        return $icon;
    }

    protected function getUrls($item){
        $urls = [];
        array_push($urls, $item['url']??'#');
        $this->getCrudUrls($item, $urls);
        $this->getExtraUrls($item, $urls);

        return $urls;
    }

    protected function getExtraUrls($item, &$urls){
        foreach ($item['extra_urls'] ?? [] as $url) {
            array_push($urls, $url);
        }
    }

    protected function getCrudUrls($item, &$urls){
        if (isset($item['crud'])) {
            array_push($urls, $item['crud'].'.create');
            array_push($urls, $item['crud'].'.edit');
            array_push($urls, $item['crud'].'.show');
        }
    }
}
