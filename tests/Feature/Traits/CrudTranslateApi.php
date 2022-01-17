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

        $user = $this->getUser();

        $response = $this->post('/api/v1/blog');
        $response->assertStatus(200);

        // $this->assertDatabaseHas($model->getTable(), [
        //     'id' => $model->id,
        // ]);
        //
        // $this->assertDatabaseHas($translation->getTable(), [
        //     'id' => $translation->id,
        // ]);
    }
}
