<?php

namespace App\Services\Transfer;

use App\Exceptions\TransferException;
use App\Exceptions\UnexpectedException;
use App\Models\User;

abstract class TransferService
{
    abstract function execute($username, $amount);

    protected function getWalletFrom()
    {
        $wallet = auth()->user()->wallet;
        throw_if(
            is_null($wallet),
            UnexpectedException::class,
            __('errors.doesnt_exist', ['attribute' => 'from wallet'])
        );
        return $wallet;
    }

    protected function getWalletTo($username)
    {
        $user = User::username($username)->with(['wallet'])->first();
        throw_if(
            is_null($user),
            UnexpectedException::class,
            __('errors.doesnt_exist', ['attribute' => 'user'])
        );

        throw_if(
            is_null($user->wallet),
            UnexpectedException::class,
            __('errors.doesnt_exist', ['attribute' => 'to wallet'])
        );
        return $user->wallet;
    }

    protected function withdrawal($balance, $amount)
    {
        throw_if(
            bccomp($balance, $amount)<0,
            TransferException::class,
            __('errors.not_enough_balance')
        );

        return bcsub($balance, $amount);
    }

    protected function refill($balance, $amount)
    {
        return bcadd($balance, $amount);
    }
}
