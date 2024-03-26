<?php

namespace App\Console\Commands;

use App\Models\Transport;
use App\Services\LotService;
use Illuminate\Console\Command;
use App\Services\PaymentService;

class DailyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for daily tasks';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        app(LotService::class)->startActiveLots();
        app(LotService::class)->endLots();
        app(PaymentService::class)->checkUserPayments();
    }
}
