<?php

namespace Sdkconsultoria\Base\Tests\Feature\Traits;

trait CrudTranslateApi
{
    public function testCreate()
    {
        $this->loginUser();
        $model = $this->model::factory()->make();
        $translation = $model->getTranslatableModel()::factory([
            'translatable_id' => $model->id
            ])->make();

        $translation_attributes = $model->getModelAttributesFromCreateRules();
        $translation_values = $translation->convertModelAttributesToArray($translation_attributes, $translation);

        $full_data = array_merge($translation_values, ['identifier' => $model->identifier]);

        $response = $this->post('/api/v1/blog', $full_data);

        $response->assertStatus(200);

        $attributes = $model->getModelAttributes();

        $response->assertJsonFragment($full_data);

        //
        // $this->assertDatabaseHas($model->getTable(), [
        //     'identifier' => $model->identifier,
        // ]);

        // $this->assertDatabaseHas($translation->getTable(), [
        //     'id' => $translation->id,
        // ]);
    }
}
