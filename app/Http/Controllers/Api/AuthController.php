<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends ApiController
{
    public function register()
    {
        $fields = request()->validate([
            'name' => 'required|min:6|max:32',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8'
        ]);

        $fields['password'] = Hash::make($fields['password']);
        $user = User::create($fields);
        $user->wallet()->create();
        $token = $user->createToken('api-token')->plainTextToken;
        return $this->respondSuccess(['token' => $token]);
    }

    public function login()
    {
        $fields = request()->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::username($fields['username'])->first();

        if (is_null($user) || !Hash::check($fields['password'], $user->password)) {
            return $this->respondFailValidated([
                'login' => 'auth.failed',
                'password' => 'auth.failed'
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;
        return $this->respondSuccess(['token' => $token]);
    }

    public function logout()
    {
        auth()->currentAccessToken()->delete();
        return $this->respondSuccess();
    }
}
