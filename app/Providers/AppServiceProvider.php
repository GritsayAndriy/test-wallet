<?php

namespace App\Providers;

use App\Console\Commands\NewPayment;
use App\Http\Controllers\Api\TransferController;
use App\Services\Transfer\ClientTransferService;
use App\Services\Transfer\RefillBalanceService;
use App\Services\Transfer\TransferService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
