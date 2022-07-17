<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Password;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_login_page()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertSessionHasNoErrors();

        $response->assertStatus(302);
    }

    public function test_user_can_login_invalid_password()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'somethingwrong'
        ]);

        $response->assertSessionHasErrors([
            'email' => 'Estas credenciales no coinciden con nuestros registros.'
        ]);

        $response->assertStatus(302);
    }

    public function test_send_reset_email_token()
    {
        $response = $this->get('/forgot-password');
        $response->assertStatus(200);

        $user = User::factory()->create();

        $response = $this->post('/forgot-password', [
            'email' => $user->email,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('status', '¡Recordatorio de contraseña enviado!');
    }

    public function test_reset_password()
    {
        $response = $this->get('/reset-password/4403187def7f3741327a1360f5a4efec385df844a4566a99fd39ea4308f8690d?email=admin%40sdkconsultoria.com');
        $response->assertStatus(200);

        $user = User::factory()->create();

        $token = Password::broker()->createToken($user);

        $password = 'newPassword23@';

        $response = $this
            ->post('reset-password', [
                'token' => $token,
                'email' => $user->email,
                'password' => $password,
                'password_confirmation' => $password,
            ]);

        $user->refresh();

        $response->assertRedirect('login');
        $this->assertFalse(Hash::check('password', $user->password));
        $this->assertTrue(Hash::check($password, $user->password));
    }
}
