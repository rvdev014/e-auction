<?php

namespace App\Console\Commands;

use App\Models\Lot;
use App\Models\User;
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
        /*$users = User::all();
        $users->each(function(User $user) {
            $user->generateLotsMemberNumber();
        });

        $lots = Lot::all();
        $lots->each(function(Lot $lot) {
            $number = ltrim($lot->number, '0');
            $lot->number = str_pad($number, 5, '0', STR_PAD_LEFT);
            $lot->save();
        });*/

//        User::factory()->count(1)->create();

//        app(SmsService::class)->sendSms('998935146491', 'Test message from TestCommand.');
    }
}
