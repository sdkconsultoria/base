<?php

namespace Sdkconsultoria\Base\Tests\Feature\Traits\CrudTranslateApi;

trait Delete
{
    public function testDeleteWithoutPermission()
    {
        $user = $this->loginUser();

        $model = $this->model::factory()->create();
        $translation = $model->getTranslatableModel()::factory([
            'translatable_id' => $model->id
            ])->create();

        $response = $this->delete('/api/v1/' . $model->getApiEndpoint() . '/' . $model->id);
        $response->assertStatus(403);
    }

    public function testDeleteWithSpecificPermission()
    {
        $user = $this->loginUser();

        $model = $this->model::factory()->create();
        $translation = $model->getTranslatableModel()::factory([
            'translatable_id' => $model->id
            ])->make();

        $permision = $model->getPermissionName('delete');
        $user->givePermissionTo($permision);

        $response = $this->delete('/api/v1/' . $model->getApiEndpoint() . '/' . $model->id);
        $response->assertStatus(200);
        $this->assertSoftDeleted($model);

        $user->revokePermissionTo($permision);
    }

    public function testDelete()
    {
        $this->loginSuperAdmin();

        $model = $this->model::factory()->create();
        $translation = $model->getTranslatableModel()::factory([
            'translatable_id' => $model->id
            ])->create();

        $response = $this->delete('/api/v1/' . $model->getApiEndpoint() . '/' . $model->id);
        $response->assertStatus(200);
        $this->assertSoftDeleted($model);
    }
}
