<?php

namespace Sdkconsultoria\Base\Tests\Traits;

use App\Models\User;

trait PolicyTest
{
    protected function getUser()
    {
        return User::factory()
            ->create(['role' => 'god', 'account_id' => '100000'])
            ->removeRole('user');
    }

    public function testViewPolicy()
    {
        $user = $this->getUser();
        $response = $this->actingAs($user)->get('nova-api/' . $this->api);
        $response->assertForbidden();

        $user->givePermissionTo($this->permission . ':viewAny');
        $response = $this->actingAs($user)->get('nova-api/' . $this->api);
        $response->assertStatus(200);
    }

    public function testViewAnyPolicy()
    {
        $user = $this->getUser();
        $model = $this->model::factory()->create();

        $response = $this->actingAs($user)->get('nova-api/' . $this->api . '/1');
        $response->assertForbidden();

        $user->givePermissionTo($this->permission . ':viewAny');
        $user->givePermissionTo($this->permission . ':view');
        $response = $this->actingAs($user)->get('nova-api/' . $this->api . '/1');
        $response->assertStatus(200);
    }

    public function testCreatePolicy()
    {
        $user = $this->getUser();
        $response = $this->actingAs($user)->post('nova-api/' . $this->api);
        $response->assertForbidden();

        $user->givePermissionTo($this->permission . ':viewAny');
        $user->givePermissionTo($this->permission . ':create');
        $response = $this->actingAs($user)->post('nova-api/' . $this->api);

        if ($this->create_empty) {
            $response->assertStatus(201);
        } else {
            $response->assertStatus(302);
        }
    }

    public function testUpdatePolicy()
    {
        $user = $this->getUser();
        $model = $this->model::factory()->create();
        $response = $this->actingAs($user)
            ->put('nova-api/' . $this->api . '/' . $model->id . '?editing=true&editMode=update');
        $response->assertForbidden();

        $user->givePermissionTo($this->permission . ':viewAny');
        $user->givePermissionTo($this->permission . ':update');
        $response = $this->actingAs($user)
            ->put('nova-api/' . $this->api . '/' . $model->id . '?editing=true&editMode=update');

        if ($this->create_empty) {
            $response->assertStatus(200);
        } else {
            $response->assertStatus(302);
        }
    }

    public function testDeletePolicy()
    {
        $user = $this->getUser();
        $model = $this->model::factory()->create();
        $response = $this->actingAs($user)->delete('nova-api/' . $this->api . '?resources[]=' . $model->id);
        $response->assertForbidden();

        $user->givePermissionTo($this->permission . ':viewAny');
        $user->givePermissionTo($this->permission . ':delete');
        $response = $this->actingAs($user)->delete('nova-api/' . $this->api . '?resources[]=' . $model->id);
        $response->assertStatus(200);
    }
}
