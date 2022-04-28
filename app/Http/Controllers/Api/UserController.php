<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;

class UserController extends ApiController
{
    public function info()
    {
        auth()->user()->load('wallet');
        return $this->respondSuccess(new UserResource(auth()->user()));
    }
}
