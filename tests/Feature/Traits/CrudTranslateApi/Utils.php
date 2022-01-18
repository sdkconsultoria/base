<?php

namespace Sdkconsultoria\Base\Tests\Feature\Traits\CrudTranslateApi;

trait Utils
{
    private function assertModel($model, $translation, $translation_values)
    {
        $this->assertDatabaseHas($model->getTable(), [
            'identifier' => $model->identifier,
        ]);

        unset($translation_values['identifier']);
        $this->assertDatabaseHas($translation->getTable(), $translation_values);
    }
}
