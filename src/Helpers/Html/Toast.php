<?php

namespace Sdkconsultoria\Base\Helpers\Html;

/**
 *
 */
class Toast extends BaseHtml implements iHtml
{
    private $class = '';
    private $icon = '';
    private $message = '';

    public static function make(array $options = [])
    {
        return new self();
    }

    public function getToast()
    {
        if (session('toast')) {
            $type = session('toast')['type'];
            $text = $this->getIcon($type) . ' <p>' . session('toast')['text'] . '</p>';
            $text = str_replace(array("\r", "\n"), '', $text);

            return '{type: \'' . $type . '\', text: \'' . $text . '\'}';
        }

        return false;
    }

    public function getIcon($type)
    {
        switch ($type) {
            case 'success':
                return '
                <div class="text-green-500 rounded-full bg-white mr-3">
                    <svg width="1.8em" height="1.8em" viewBox="0 0 16 16" class="bi bi-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z"/>
                    </svg>
                </div>';
                break;

            case 'danger':
                return '
                <div class="text-red-500 rounded-full bg-white mr-3">
                 <svg width="1.8em" height="1.8em" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                   <path fill-rule="evenodd" d="M11.854 4.146a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708-.708l7-7a.5.5 0 0 1 .708 0z"/>
                   <path fill-rule="evenodd" d="M4.146 4.146a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7a.5.5 0 0 0-.708 0z"/>
                 </svg>
                </div>';
                break;

            case 'warning':
                return '
                <div class="text-yellow-500 rounded-full bg-white mr-3">
                  <svg width="1.8em" height="1.8em" viewBox="0 0 16 16" class="bi bi-exclamation" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                  </svg>
                </div>';
                break;

            case 'primary':
                return '
                <div class="text-blue-500 rounded-full bg-white mr-3">
                   <svg width="1.8em" height="1.8em" viewBox="0 0 16 16" class="bi bi-info" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                      <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z"/>
                      <circle cx="8" cy="4.5" r="1"/>
                   </svg>
                </div>';
                break;

            default:
                // code...
                break;
        }

    }

    public function render()
    {
        $toast = $this->getToast();

        if (!$toast) {
            return '';
        }

        return
        '<div
            x-data="noticesHandler()"
            class="z-50 fixed inset-0 flex flex-col-reverse items-end justify-start h-screen w-screen"
            x-on:notice.window="add($event.detail)"
            style="pointer-events:none">
            <template x-for="notice of notices" :key="notice.id">
                <div
                    x-show="visible.includes(notice)"
                    x-transition:enter="transition ease-in duration-200"
                    x-transition:enter-start="transform opacity-0 translate-y-2"
                    x-transition:enter-end="transform opacity-100"
                    x-transition:leave="transition ease-out duration-500"
                    x-transition:leave-start="transform translate-x-0 opacity-100"
                    x-transition:leave-end="transform translate-x-full opacity-0"
                    x-on:click="remove(notice.id)"
                    class="z-50 p-2 max-w-xs bg-green-500 border-l-4 border-green-700 rounded-lg flex items-center mb-4 mr-6 text-white shadow-lg font-bold text-xl cursor-pointer"
                    :class="{
                        \'bg-green-500 border-green-700\': notice.type === \'success\',
                        \'bg-blue-500 border-blue-700\': notice.type === \'info\',
                        \'bg-yellow-500 border-yellow-700\': notice.type === \'warning\',
                        \'bg-red-500 border-red-700\': notice.type === \'error\',
                    }"
                    style="pointer-events:all"
                    x-html="notice.text">
                </div>
            </template>
        </div>
        <script type="text/javascript">
            setTimeout(function () {
                var event = new CustomEvent(\'notice\', {detail: ' . $toast . ', bubbles: true});
                window.dispatchEvent(event);
            }, 300);
        </script>';
    }
}
