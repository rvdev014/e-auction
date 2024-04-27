<?php

namespace Tests\Feature;

use Carbon\Carbon;
use App\Models\Lot;
use Tests\TestCase;
use App\Enums\LotStatus;
use App\Services\LotService;
use App\Services\PaymentService;
use Tests\Helpers\LotsTestHelper;
use App\Console\Commands\DailyCommand;

class DailyCommandsTest extends TestCase
{
    use LotsTestHelper;

    protected readonly LotService $lotService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->lotService = app(LotService::class);
    }

    public function test_daily_command_run(): void
    {
        $this->mock(LotService::class)->shouldReceive('startActiveLots', 'endLots')->once();
        $this->mock(PaymentService::class)->shouldReceive('checkUserPayments')->once();

        $this->runDailyCommand();
    }

    public function test_lots_start_ignore_because_of_time(): void
    {
        $lot = Lot::factory()->create([
            'starts_at' => now()->addMinutes(3),
        ]);
        $this->addUserApplicationsToLot($lot);

        $this->assertTrue($lot->status === LotStatus::Active);

        $this->smsServiceMock->shouldNotHaveReceived('sendSms');
        $this->lotService->startActiveLots();
        $lot->refresh();

        $this->assertDatabaseCount('messages', 0);
        $this->assertFalse($lot->status === LotStatus::Started);
    }

    public function test_lots_start(): void
    {
        $lot = Lot::factory()->create([
            'starts_at' => now()->subMinutes(10)
        ]);
        $this->addUserApplicationsToLot($lot);

        $this->assertTrue($lot->status === LotStatus::Active);

        $this->smsServiceMock->shouldReceive('sendSms')->times(3);
        $this->lotService->startActiveLots();
        $lot->refresh();

        $this->assertDatabaseCount('messages', 3);
        $this->assertTrue($lot->status === LotStatus::Started);
    }

    public function test_lots_end(): void
    {
        $lot = Lot::factory()->create([
            'starts_at' => now()->subMinutes(10),
            'status' => LotStatus::Started,
        ]);

        $this->addUserApplicationsToLot($lot);
        $this->addStep($lot);

        $this->assertTrue($lot->status === LotStatus::Started);
        Carbon::setTestNow(now()->addMinutes(10));

        $this->smsServiceMock->shouldReceive('sendSms');
        $this->lotService->endLots();
        $lot->refresh();

        $this->assertTrue($lot->status === LotStatus::Ended);
    }

    public function test_lots_end_ignore_because_of_steps(): void
    {
        $lot = Lot::factory()->create([
            'starts_at' => now()->subMinutes(10),
            'status' => LotStatus::Started,
        ]);
        $this->addUserApplicationsToLot($lot);
        $this->assertTrue($lot->status === LotStatus::Started);

        $this->smsServiceMock->shouldNotHaveReceived('sendSms');
        $this->lotService->endLots();
        $lot->refresh();

        $this->assertTrue($lot->status === LotStatus::Started);
    }

    public function test_check_payments(): void
    {
        $lot = Lot::factory()->create([
            'starts_at' => now()->subMinutes(10),
            'status' => LotStatus::Started,
        ]);
        $this->addUserApplicationsToLot($lot, withSteps: true);
        Carbon::setTestNow(now()->addMinutes(10));

        $this->smsServiceMock->shouldReceive('sendSms')->times(3);

        $this->lotService->endLots();
        $lot->refresh();

        $oldWinner = $lot->winner;
        $this->assertDatabaseHas('lot_users', ['user_id' => $oldWinner->user_id, 'is_winner' => true]);

        $this->assertTrue($lot->payment_deadline > now());
        Carbon::setTestNow($this->lotService->getPaymentDeadline()->addMinute());

        app(PaymentService::class)->checkUserPayments();
        $lot->refresh();

        $newWinner = $lot->winner;
        $this->assertDatabaseHas('lot_users', ['user_id' => $oldWinner->user_id, 'is_winner' => false]);
        $this->assertDatabaseHas('lot_users', ['user_id' => $newWinner->user_id, 'is_winner' => true]);
    }

    private function runDailyCommand(): void
    {
        /** @var DailyCommand $dailyCommand */
        $dailyCommand = app(DailyCommand::class);
        $dailyCommand->handle();
    }
}
