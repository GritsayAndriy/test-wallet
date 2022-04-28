<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\TransferResource;
use App\Models\Transfer;
use App\Services\Transfer\ClientTransferService;
use Illuminate\Validation\Rule;

class TransferController extends ApiController
{
    public function history()
    {
        $wallet = auth()->user()->wallet()->first();
        if (is_null($wallet)) {
            return $this->respondError([
                'message' => __('errors.doesnt_exist', ['attribute' => 'wallet'])
            ]);
        }

        $transfers = Transfer::byWalletId($wallet->id)->latest()->get();
        return $this->respondSuccess(TransferResource::collection($transfers));
    }

    public function transfer(ClientTransferService $transferService)
    {
        $fields = request()->validate([
            'username' => ['required', 'string',
                Rule::notIn([auth()->user()->name, auth()->user()->email])],
            'amount' => 'required|numeric'
        ]);

        $transferStatus = $transferService->execute($fields['username'], $fields['amount']);
        if ($transferStatus) {
            return $this->respondSuccess();
        }
        return $this->respondError();
    }
}
