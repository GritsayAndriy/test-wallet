<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    protected $seed = true;

    protected function assertSuccessResponse(TestResponse $response)
    {
        $response->assertJsonPath('status', 'success')->assertStatus(JsonResponse::HTTP_OK);
    }

    protected function assertErrorResponse(TestResponse $response)
    {
        $response->assertJsonPath('status', 'error');
    }
}
