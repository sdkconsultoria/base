<?php

namespace Sdkconsultoria\Base\Tests\Feature\Traits\CrudTranslateApi;

trait Update
{
    public function testUpdateWithoutPermission()
    {
        $user = $this->loginUser();

        $model = $this->model::factory()->create();
        $translation = $model->getTranslatableModel()::factory([
            'translatable_id' => $model->id
            ])->create();
        $translation_new = $model->getTranslatableModel()::factory()->make();

        $translation_attributes = $model->getModelAttributesFromCreateRules();
        $translation_values = $translation->convertModelAttributesToArray($translation_attributes, $translation);
        $translation_values_new = $translation->convertModelAttributesToArray($translation_attributes, $translation_new);

        $full_data = array_merge($translation_values_new, ['identifier' => $model->identifier]);

        $response = $this->put('/api/v1/' . $model->getApiEndpoint() . '/' . $model->id, $full_data);
        $response->assertStatus(403);
    }

    public function testUpdateWithSpecificPermission()
    {
        $user = $this->loginUser();

        $model = $this->model::factory()->create();
        $permision = $model->getPermissionName('update');

        $user->givePermissionTo($permision);

        $translation = $model->getTranslatableModel()::factory([
            'translatable_id' => $model->id
            ])->create();
        $translation_new = $model->getTranslatableModel()::factory()->make();

        $translation_attributes = $model->getModelAttributesFromCreateRules();
        $translation_values = $translation->convertModelAttributesToArray($translation_attributes, $translation);
        $translation_values_new = $translation->convertModelAttributesToArray($translation_attributes, $translation_new);

        $full_data = array_merge($translation_values_new, ['identifier' => $model->identifier]);

        $response = $this->put('/api/v1/' . $model->getApiEndpoint() . '/' . $model->id, $full_data);
        $response->assertStatus(200);
        $response->assertJsonFragment($full_data);

        $this->assertModel($model, $translation_new, $translation_values_new);

        $user->revokePermissionTo($permision);
    }

    public function testUpdate()
    {
        $this->loginSuperAdmin();

        $model = $this->model::factory()->create();
        $translation = $model->getTranslatableModel()::factory([
            'translatable_id' => $model->id
            ])->create();
        $translation_new = $model->getTranslatableModel()::factory()->make();

        $translation_attributes = $model->getModelAttributesFromCreateRules();
        $translation_values = $translation->convertModelAttributesToArray($translation_attributes, $translation);
        $translation_values_new = $translation->convertModelAttributesToArray($translation_attributes, $translation_new);

        $full_data = array_merge($translation_values_new, ['identifier' => $model->identifier]);

        $response = $this->put('/api/v1/' . $model->getApiEndpoint() . '/' . $model->id, $full_data);
        $response->assertStatus(200);
        $response->assertJsonFragment($full_data);

        $this->assertModel($model, $translation_new, $translation_values_new);
    }

    private function assertModel($model, $translation, $translation_values)
    {
        $this->assertDatabaseHas($model->getTable(), [
            'identifier' => $model->identifier,
        ]);

        unset($translation_values['identifier']);
        $this->assertDatabaseHas($translation->getTable(), $translation_values);
    }
}
