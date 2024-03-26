<?php

namespace App\Console\Commands;

use App\Models\Lot;
use App\Models\Transport;
use App\Services\SmsService;
use Illuminate\Console\Command;
use App\Providers\Filament\AdminPanelProvider;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for testing purposes.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        /*$lot = Lot::find(1);
        dd($lot->winnerStep);*/

        app(SmsService::class)->sendSms('998935146491', 'Test message from TestCommand.');

        /*$transports = Transport::with('categories')->get();
        foreach ($transports as $transport) {
            $this->info($transport->name . ' (' . $transport->owner . ')' . ' - ' . $transport->car_number);
            $this->info("Categories: " . $transport->categories->pluck('title')->implode(', ') . "\n");
            $this->info('---');
        }*/
    }
}
