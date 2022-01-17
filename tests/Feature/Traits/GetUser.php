<?php

namespace Sdkconsultoria\Base\Tests\Feature\Traits;

use App\Models\User;
use Laravel\Sanctum\Sanctum;

trait GetUser
{
    protected function getAdminUser()
    {
        $user = $this->findOrCreateUser('admin@sdkconsultoria.com');
        $this->actingAs($user);
    }

    protected function getUser()
    {
        $user = $this->findOrCreateUser('user@sdkconsultoria.com');
        $this->actingAs($user);
    }

    protected function findOrCreateUser(string $email) : User
    {
        $user = User::where('email', $email)->first();

        if ($user) {
            return $user;
        }

        return $this->createUser($email);
    }

    protected function createUser(string $email) : User
    {
        return User::factory()->create([
            'email' => $email
        ]);
    }

    // public function loginSactum(User $user) : void
    // {
    //     Sanctum::actingAs($user, ['*']);
    // }
}
