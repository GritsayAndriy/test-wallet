<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_register()
    {
        $parameters = [
            'name' => 'Nikerman',
            'email' => 'nike@gmail.com',
            'password' => '123456789',
            'password_confirmation' => '123456789'
        ];

        $response = $this->postJson(route('users.register', $parameters))->dump();

        $this->assertSuccessResponse($response);
    }

    public function test_login()
    {
        $user = User::factory()->create();
        $parameters = [
            'username' => $user->name,
            'password' => '123456789',
        ];

        $response = $this->postJson(route('users.login', $parameters))->dump();

        $this->assertSuccessResponse($response);
    }

    public function test_login_with_fail_filds()
    {
        $user = User::factory()->create();
        $parameters = [
            'username' => $user->name,
            'password' => '12345679',
        ];

        $response = $this->postJson(route('users.login', $parameters))->dump();

        $this->assertErrorResponse($response);
    }
}
