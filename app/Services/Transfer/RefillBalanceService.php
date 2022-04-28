<?php

namespace App\Services\Transfer;

use App\Models\Transfer;
use Illuminate\Support\Facades\DB;

class RefillBalanceService extends TransferService
{
    public function execute($username, $amount)
    {
        $toWallet = $this->getWalletTo($username);
        $toWallet->balance = $this->refill($toWallet->balance, $amount);

        try {
            DB::beginTransaction();
            $toWallet->save();
            Transfer::create([
                'to_id' => $toWallet->id,
                'amount' => $amount,
            ]);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            return false;
        }
    }

}
