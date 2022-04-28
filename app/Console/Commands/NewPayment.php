<?php

namespace App\Console\Commands;

use App\Services\Transfer\RefillBalanceService;
use Illuminate\Console\Command;

class NewPayment extends Command
{
    protected $signature = 'new-payment {username} {amount}';

    protected $description = 'Command description';

    public function handle(RefillBalanceService $refillBalanceService)
    {
        try {
            $transferStatus = $refillBalanceService->execute(
                $this->argument('username'),
                $this->argument('amount')
            );
            if ($transferStatus) {
                $this->info('The command was successful!');
                return 0;
            }
            $this->error('Something went wrong!');
            return $transferStatus ? 0 : 1;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
            return 1;
        }
    }
}
