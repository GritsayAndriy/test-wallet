<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class TransferTest extends TestCase
{
    public function test_transfers_history()
    {
        $user = User::with('wallet')->first();
        $token = $user->createToken('api-token');

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token->plainTextToken])
            ->getJson(route('finances.history'))->dump();

        $this->assertSuccessResponse($response);
    }

    public function test_transfer_by_email()
    {
        $users = User::with('wallet')->get();

        $token = $users[0]->createToken('api-token');
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token->plainTextToken])
            ->postJson(route('finances.transfer', [
                'username' => $users[1]->email,
                'amount' => '10',
            ]))->dump();

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('wallets', [
            'user_id' => $users[0]->id,
            'balance' => bcsub($users[0]->wallet->balance, '10'),
        ]);
    }

    public function test_transfer_with_username()
    {
        $users = User::with('wallet')->get();

        $token = $users[0]->createToken('api-token');
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token->plainTextToken])
            ->postJson(route('finances.transfer', [
                'username' => $users[1]->name,
                'amount' => '10',
            ]))->dump();

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('wallets', [
            'user_id' => $users[0]->id,
            'balance' => bcsub($users[0]->wallet->balance, '10'),
        ]);
    }
}
