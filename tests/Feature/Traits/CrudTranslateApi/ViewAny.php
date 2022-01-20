<?php

namespace Sdkconsultoria\Base\Tests\Feature\Traits\CrudTranslateApi;

trait ViewAny
{
    public function testViewAnyWithoutPermission()
    {
        $user = $this->loginUser();

        $model = $this->model::factory()->create();
        $translation = $model->getTranslatableModel()::factory([
            'translatable_id' => $model->id
            ])->create();

        $response = $this->get('/api/v1/' . $model->getApiEndpoint());
        $response->assertStatus(403);
    }

    public function testViewAnyWithSpecificPermission()
    {
        $user = $this->loginUser();

        $model = $this->model::factory()->create();
        $translation = $model->getTranslatableModel()::factory([
            'translatable_id' => $model->id
            ])->make();

        $permision = $model->getPermissionName('viewAny');
        $user->givePermissionTo($permision);

        $response = $this->get('/api/v1/' . $model->getApiEndpoint());
        $user->revokePermissionTo($permision);
        $response->assertStatus(200);

    }

    public function testViewAny()
    {
        $this->loginSuperAdmin();

        $model = $this->model::factory()->create();
        $translation = $model->getTranslatableModel()::factory([
            'translatable_id' => $model->id
            ])->create();

        $response = $this->get('/api/v1/' . $model->getApiEndpoint());
        $response->assertStatus(200);
    }

    public function testFilterBy()
    {
        $model = $this->model::factory()->create();

        for ($i=0; $i < 5; $i++) {
            $this->model::factory()->create();
        }

        $response = $this->get('/api/v1/' . $model->getApiEndpoint());


    }

    public function testOrderBy()
    {

    }
}
