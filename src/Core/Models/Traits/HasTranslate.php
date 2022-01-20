<?php

namespace Sdkconsultoria\Base\Core\Models\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasTranslate
{
    public function translate(string $language = '')
    {
        $translation_class = $this->getTranslatableClassOrFail();
        $language = $this->getLanguageIfNotSet($language);

        $translation = $this->hasOne($translation_class, 'translatable_id', 'id')->where('language', $language);

        return $translation;
    }

    public function getTranslatableModel(string $language = '') : Model
    {
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
            $language = app()->getLocale();
        }

        return $language;
    }
}
