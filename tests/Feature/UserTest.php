<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_info()
    {
        $user = User::first();
        $token = $user->createToken('api-token');
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token->plainTextToken])
            ->getJson(route('users.info'))->dump();

        $this->assertSuccessResponse($response);
    }
}
