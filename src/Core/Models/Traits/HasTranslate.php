<?php

namespace Sdkconsultoria\Base\Core\Models\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasTranslate
{
    public $translation = null;

    public function getTranslatableModel(string $language = '') : Model
    {
        if ($this->translation) {
            return $this->translation;
        }

        $translation_class = $this->getTranslatableClassOrFail();
        $language = $this->getLanguageIfNotSet($language);

        $translation = $translation_class::where('translatable_id', $this->id)
            ->where('language', $language)
            ->first();

        if ($translation) {
            return $translation;
        }

        return new $translation_class;
    }

    public function getTranslatableClassOrFail() : ?string
    {
        $class = $this->getTranslatableClass();

        if (!class_exists($class)) {
            throw new \Exception("Translation Class do not exists", 1);
        }

        return $class;
    }

    public function getTranslatableClass() : string
    {
        if (isset($this->translatable)) {
            return $this->translatable;
        }

        $class = get_called_class();

        return $class . 'Translate';
    }

    private function getLanguageIfNotSet(string $language = '') : string
    {
        if (!$language) {
            $language = config('app.locale');
        }

        return $language;
    }
}
