<?php

namespace Sdkconsultoria\Base\Traits;

trait TranslateModel
{
    /**
     * Obtiene el blog real.
     */
    public function translate(bool $class = false, string $language = '')
    {
        if ($class) {
            return $this->translateClass;
        }

        $language = $language ? $language : app()->getLocale();
        return $this->hasOne($this->translateClass)->where('language', $language);
    }
}
