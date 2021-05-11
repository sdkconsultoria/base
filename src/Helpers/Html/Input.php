<?php

namespace Sdkconsultoria\Base\Helpers\Html;

use Base;
use Sdkconsultoria\Base\Helpers\Html\Taggeable\Select;

/**
 *
 */
class Input extends BaseHtml  implements iHtml
{
    private $optionsWrap = ['class' => 'form-group'];
    private $optionsHtml = ['class' => 'form-control form-control-l form-control-r border-gray-300'];
    private $attributes = '';
    private $input = '';
    private $prepend = '';
    private $append = '';
    private $invalidClass = 'border-red-500';
    private $validClass = 'border-green-500';
    private $name = '';
    private $validWith = '';
    private $feedback = '';
    private $isValid = true;
    private $wasValidate = false;
    private $label = false;
    private $generateLabel = true;
    private $validate = true;
    private $translate = '';
    private $wrap = true;
    private $value;
    private $model;
    private $endContent;

    public function label($label = true, array $optionsHtml = ['class' => 'text-gray-600 font-medium'])
    {
        if ($label) {
            if ($label !== true) {
                $this->label = $label;
            }
            $this->label = '<label ' . self::setAttributes($optionsHtml) . ' > ' . $this->translate . ' </label>';
        }else {
            $this->generateLabel = false;
        }

        return $this;
    }

    public function setTranslate(string $translate = '')
    {
        $this->translate = $translate;
        return $this;
    }

    public static function make(array $options = [])
    {
        $object = new self;
        $object->name = $options['name'];
        $object->validWith = $options['name'];
        $object->value = $options['value'] ?? '';
        $object->model = $options['model_remove'] ?? '';
        unset($options['model_remove']);
        $object->optionsHtml = array_merge($object->optionsHtml, $options);
        $object->optionsHtml['value'] = old($object->name) ?? $object->optionsHtml['value'] ?? '';

        return $object;
    }

    public function textInput(array $options = [])
    {
        $this->prepareInput();
        $this->input = '<input type="text" ' . $this->optionsHtml . ' />';

        return $this;
    }

    public function fileInput(array $options = ['class' => 'border-gray-300'])
    {
        $this->optionsHtml = array_merge($this->optionsHtml, $options);
        $this->prepareInput();
        $this->input = '<input type="file" ' . $this->optionsHtml . ' />';

        return $this;
    }


    public function taggableInput(array $options = [])
    {
        $this->generateLabel = false;
        $this->optionsHtml = array_merge($this->optionsHtml, $options);
        $this->prepareInput();
        $this->input = Select::make($this->model);
        $this->endContent = Base::taggeable([
            'tags' => $this->model->tags,
            'model' => $this->model,
        ]);

        return $this;
    }

    public function imageInput(array $options = [], string $target = '')
    {
        $this->optionsHtml = array_merge($this->optionsHtml, $options);
        $this->prepareInput();
        $this->input = '
            <div
            id="drop-region"
            class="bg-white rounded-lg border-2 border-dotted p-2 border-blue-500"
            data-target="'.$target.'"
            data-upload="' . route('image.upload-single', ['class' => $this->model::class, 'id' => $this->model->id]) . '">
                <div class="drop-message">
                    ' . __('base::models.image.upload_one') . '
                </div>
                <div id="image-preview" class="flex flex-row flex-wrap"></div>
            </div>';

        return $this;
    }

    public function imagesInput(array $options = [], bool $openType = false)
    {
        $this->optionsHtml = array_merge($this->optionsHtml, $options);
        $this->prepareInput();
        $this->input = '
            <div
            id="drop-region"
            class="bg-white rounded-lg border-2 border-dotted p-2 border-blue-500"
            data-upload="' . route('image.upload', ['class' => $this->model::class, 'id' => $this->model->id]) . '">
                <div class="drop-message">
                    ' . __('base::models.image.upload_one') . '
                </div>
                <div id="image-preview" class="flex flex-row flex-wrap"></div>
            </div>';

        $this->endContent = Base::imageable([
            'images' => $this->model->images,
            'table' => $this->model->getTable(),
            'openType' => $openType
        ]);

        return $this;
    }

    public function textArea(array $options = [])
    {
        $this->optionsHtml = array_merge($this->optionsHtml, $options);
        $this->prepareInput();
        $this->input = '<textarea ' . $this->optionsHtml . '>' . $this->value . '</textarea>';

        return $this;
    }

    public function dropDown(array $items, array $options = [], $empty = 'base::app.common.select')
    {
        $this->prepareInput();

        $this->input = '
        <select  ' . $this->optionsHtml . ' >
            <option value=""> ' . trans_choice($empty, 1,['item' => $this->translate]) . ' </option>';
        foreach ($items as $key => $value) {
            $this->input .= '<option ' . ($this->value == $key ? 'selected' : '') . ' value="' . $key . '">' .  $value . '</option>';
        }
        $this->input .= '</select>';

        return $this;
    }

    public function passwordInput(array $options = [])
    {
        $this->optionsHtml['value'] = '';
        $this->prepareInput();
        $this->input = '<input type="password" ' . $this->optionsHtml . ' />';

        return $this;
    }

    public function feedback(string $errors = '')
    {
        $this->feedback .= '<div class="text-red-500 text-xs font-semibold -mt-2">' . $this->getErrors($errors) . '</div>';
    }

    public function prepend(string $text = '', $options = ['style' => 'width: 40px', 'class' => 'input-prepend'])
    {
        $this->optionsHtml['class'] = str_replace('form-control-l', '', $this->optionsHtml['class']);
        $this->prepend = '<div ' . self::setAttributes($options) . '>
                              '.$text.'
                          </div>';


        return $this;
    }

    public function append(string $text = '', $options = ['style' => 'width: 40px', 'class' => 'input-append'])
    {
        $this->optionsHtml['class'] = str_replace('form-control-r', '', $this->optionsHtml['class']);
        $this->append = '<div ' . self::setAttributes($options)  . '>
                            '.$text.'
                        </div>';

        return $this;
    }

    public function validate($validate = true)
    {
        if (is_bool($validate)) {
            $this->validate = $validate;
        }else{
            $this->validWith = $validate;
        }

        return $this;
    }

    private function fixHtmlOptions()
    {
        if ($this->wasValidate) {
            if ($this->validate) {
                if ($this->isValid) {
                    $this->optionsHtml['class'] .= ' ' . $this->validClass;
                } else {
                    $this->optionsHtml['class'] .= ' ' . $this->invalidClass;
                }
            }
        }

        $this->optionsHtml['placeholder'] = $this->optionsHtml['placeholder'] ?? $this->translate;

    }

    private function getErrors(string $errors = '')
    {
        if ($errors) {
            return $errors;
        }

        if (session('errors')) {
            $this->wasValidate = true;
        }

        $error_messages = session('errors')?session('errors')->getMessages():[];
        $error_messages = $error_messages[$this->validWith]??[];
        foreach ($error_messages as $value) {
            $this->isValid = false;

            $errors .= $this->translateName($value);
        }

        return $errors;
    }

    private function translateName($text)
    {
        if ($this->translate) {
            $translate = str_replace($this->name, $this->translate, $text);
            $translate = str_replace(str_replace('_', ' ', $this->name), $this->translate, $text);
            return $translate;
        }

        return $text;
    }

    private function prepareInput()
    {
         $this->feedback();
         $this->fixHtmlOptions();
         $this->optionsHtml = self::setAttributes($this->optionsHtml);
    }

    public function wrap($wrap, $optionsWrap = [])
    {
        $this->wrap = $wrap;
        $this->optionsWrap = $optionsWrap;

        return $this;
    }

    public function render()
    {
        if (!$this->input) {
            $this->textInput();
        }

        if (!$this->label && $this->generateLabel) {
            $this->label();
        }

        $this->optionsWrap = self::setAttributes($this->optionsWrap);

        $html = $this->label . '<div class="flex flex-row w-full">' . $this->prepend . $this->input . $this->append . '</div>';

        if (!$this->wrap) {
            return $html;
        }

        return '<div ' . $this->optionsWrap . ' >' . $html .'</div>' . $this->feedback . $this->endContent;
    }

}
