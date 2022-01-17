<?php

namespace Sdkconsultoria\Base\Tests\Feature\Traits;

trait CrudTranslateApi
{
    public function testCreateWithSpecificPermission()
    {
        $user = $this->loginUser();
        $model = $this->model::factory()->make();
        $permision = $model->getPermissionName('create');
        $user->givePermissionTo($permision);
        $translation = $model->getTranslatableModel()::factory([
            'translatable_id' => $model->id
            ])->make();

        $translation_attributes = $model->getModelAttributesFromCreateRules();
        $translation_values = $translation->convertModelAttributesToArray($translation_attributes, $translation);

        $full_data = array_merge($translation_values, ['identifier' => $model->identifier]);

        $response = $this->post('/api/v1/' . $model->getApiEndpoint(), $full_data);
        $response->assertStatus(200);
        $user->revokePermissionTo($permision);
    }

    public function testCreateWithoutPermission()
    {
        $user = $this->loginUser();

        $model = $this->model::factory()->make();
        $translation = $model->getTranslatableModel()::factory([
            'translatable_id' => $model->id
            ])->make();

        $translation_attributes = $model->getModelAttributesFromCreateRules();
        $translation_values = $translation->convertModelAttributesToArray($translation_attributes, $translation);

        $full_data = array_merge($translation_values, ['identifier' => $model->identifier]);

        $response = $this->post('/api/v1/' . $model->getApiEndpoint(), $full_data);
        $response->assertStatus(403);
    }

    public function testCreate()
    {
        $this->loginSuperAdmin();

        $model = $this->model::factory()->make();
        $translation = $model->getTranslatableModel()::factory([
            'translatable_id' => $model->id
            ])->make();

        $translation_attributes = $model->getModelAttributesFromCreateRules();
        $translation_values = $translation->convertModelAttributesToArray($translation_attributes, $translation);

        $full_data = array_merge($translation_values, ['identifier' => $model->identifier]);

        $response = $this->post('/api/v1/' . $model->getApiEndpoint(), $full_data);
        $response->assertStatus(200);
        $response->assertJsonFragment($full_data);

        $this->assertDatabaseHas($model->getTable(), [
            'identifier' => $model->identifier,
        ]);

        $this->assertDatabaseHas($translation->getTable(), [
            'title' => $translation->title,
            'subtitle' => $translation->subtitle,
            'description' => $translation->description,
        ]);
    }
}
