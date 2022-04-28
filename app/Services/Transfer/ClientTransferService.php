<?php

namespace App\Services\Transfer;

use App\Models\Transfer;
use Illuminate\Support\Facades\DB;

class ClientTransferService extends TransferService
{
    public function execute($username, $amount)
    {
        $walletFrom = $this->getWalletFrom();
        $walletTo = $this->getWalletTo($username);

        $walletFrom->balance = $this->withdrawal($walletFrom->balance, $amount);
        $walletTo->balance = $this->refill($walletTo->balance, $amount);

        try {
            DB::beginTransaction();
            $walletFrom->save();
            $walletTo->save();
            Transfer::create([
                'from_id' => $walletFrom->id,
                'to_id' => $walletTo->id,
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
