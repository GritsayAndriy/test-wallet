<?php

namespace Database\Seeders;

use App\Models\Transfer;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    public function run()
    {
        $users = User::factory(2)->create();
        foreach ($users as $user) {
            $user->wallet()->create(['balance' => 1000]);
        }
        Transfer::create([
            'from_id' => $users[0]->id,
            'to_id' => $users[1]->id,
            'amount' => 200,
        ]);
    }
}
