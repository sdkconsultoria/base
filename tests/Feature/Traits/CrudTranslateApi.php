<?php

namespace Sdkconsultoria\Base\Tests\Feature\Traits;

trait CrudTranslateApi
{
    public function testCreate()
    {
        $model = $this->model::factory()->make();
        $translation = $model->getTranslatableModel()::factory([
            'translatable_id' => $model->id
            ])->make();
        $model->translation = $translation;
        $user = $this->getUser();

        $response = $this->post('/api/v1/blog');
        $response->assertStatus(200);

        $attributes = $model->getModelAttributes();

        $response->assertJsonFragment([
            'model' => [
                'identifier' => $model->identifier,
            ]
        ]);
        //
        // $this->assertDatabaseHas($model->getTable(), [
        //     'identifier' => $model->identifier,
        // ]);

        // $this->assertDatabaseHas($translation->getTable(), [
        //     'id' => $translation->id,
        // ]);
    }
}
