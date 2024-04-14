<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;


class LoginTest extends TestCase
{

    public function test_login_validation()
    {
        $this->postJson(route('auth.login'), [])
            ->assertJsonValidationErrors(['username', 'password']);

        $this->postJson(route('auth.login'), [
            'username' => 'ssssN',
            'password' => 'password',
        ])->assertJsonValidationErrorFor('username');
    }

    public function test_sanctum_login()
    {
        $user = User::factory()->create(['email'=>'test@gmail.com']);

        $response = $this->postJson(route('auth.login'), [
            'username' => $user->email,
            'password' => 'password',
        ]);

        $response->assertSuccessful()
            ->assertJsonStructure(['token']);

    }
}
