<?php

namespace Sdkconsultoria\Base\Tests\Feature\Traits\CrudTranslateApi;

trait View
{
    public function testViewWithoutPermission()
    {
        $user = $this->loginUser();

        $model = $this->model::factory()->create();
        $translation = $model->getTranslatableModel()::factory([
            'translatable_id' => $model->id
            ])->create();

        $response = $this->get('/api/v1/' . $model->getApiEndpoint() . '/' . $model->id);
        $response->assertStatus(403);
    }

    public function testViewWithSpecificPermission()
    {
        $user = $this->loginUser();

        $model = $this->model::factory()->create();
        $translation = $model->getTranslatableModel()::factory([
            'translatable_id' => $model->id
            ])->make();

        $permision = $model->getPermissionName('view');
        $user->givePermissionTo($permision);

        $response = $this->get('/api/v1/' . $model->getApiEndpoint() . '/' . $model->id);
        $user->revokePermissionTo($permision);
        $response->assertStatus(200);
        $response->assertJsonFragment($model->getAttributes());

    }

    public function testView()
    {
        $this->loginSuperAdmin();

        $model = $this->model::factory()->create();
        $translation = $model->getTranslatableModel()::factory([
            'translatable_id' => $model->id
            ])->create();

        $response = $this->get('/api/v1/' . $model->getApiEndpoint() . '/' . $model->id);
        $response->assertStatus(200);
        $response->assertJsonFragment($model->getAttributes());
    }
}
