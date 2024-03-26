<?php

namespace Tests\Feature;

use Throwable;
use Carbon\Carbon;
use App\Models\Lot;
use Tests\TestCase;
use App\Models\User;
use App\Models\LotUser;
use App\Enums\LotStatus;
use Laravel\Sanctum\Sanctum;
use App\Services\LotService;
use Tests\Helpers\LotsTestHelper;

class LotTest extends TestCase
{
    use LotsTestHelper;

    private readonly LotService $lotService;

    public function setUp(): void
    {
        parent::setUp();

        $this->lotService = app(LotService::class);
    }

    public function test_lot_creating_with_number(): void
    {
        $lot = Lot::factory()->create();
        $expectedNumber = str_pad($lot->id, 10, '0', STR_PAD_LEFT);

        $this->assertEquals($expectedNumber, $lot->number);
    }

    public function test_lot_is_active_and_can_be_started(): void
    {
        $newLot = Lot::factory()->create([
            'starts_at' => now()->addMinutes(3),
            'ends_at' => now()->addMinutes(5),
        ]);

        $this->assertFalse($newLot->isActive());

        $this->addUserApplicationsToLot($newLot);

        $this->assertTrue($newLot->isActive());
    }

    public function test_lot_is_applied(): void
    {
        $user = User::factory()->create();
        $lot = Lot::factory()->create();

        Sanctum::actingAs($user);
        $this->assertFalse($lot->isApplied());

        $lot->lotUsers()->create(['user_id' => $user->id]);

        $this->assertTrue($lot->isApplied());
    }

    public function test_lot_winner_relation(): void
    {
        $winner = User::factory()->create();
        $lot = Lot::factory()->create();

        $lot
            ->lotUsers()
            ->create([
                'user_id' => $winner->id,
                'is_winner' => true,
            ])
            ->steps()
            ->create(['price' => 1000]);

        $this->assertEquals($winner->id, $lot->winner->user_id);
    }

    public function test_lot_users_list(): void
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $lot = Lot::factory()->create();

        $usersData = [
            [
                'user_id' => $user->id,
                'steps' => [
                    ['price' => 1000],
                    ['price' => 3000],
                ]
            ],
            [
                'user_id' => $user2->id,
                'is_winner' => true,
                'steps' => [
                    ['price' => 2000],
                    ['price' => 4000],
                ]
            ],
        ];

        foreach ($usersData as $item) {
            /** @var LotUser $lotUser */
            $lotUser = $lot->lotUsers()->create([
                'user_id' => $item['user_id'],
                'is_winner' => $item['is_winner'] ?? false,
            ]);
            $lotUser->steps()->createMany($item['steps']);
        }

        $this->assertCount(2, $lot->users);
        $this->assertCount(4, $lot->steps);
    }

    public function test_lot_cannot_start_less_users(): void
    {
        $lot = Lot::factory()->create([
            'starts_at' => now()->subMinute(),
            'ends_at' => now()->addMinutes(20),
        ]);
        $this->assertFalse($lot->isStarted());

        $this->expectException(Throwable::class);
        $this->expectExceptionMessage('Аукцион бошлана олмайди');

        $this->lotService->startLot($lot);
    }

    public function test_lot_cannot_start_because_of_time()
    {
        $lot = Lot::factory()->create([
            'starts_at' => now()->addSeconds(10),
            'ends_at' => now()->addMinutes(20),
        ]);
        $this->addUserApplicationsToLot($lot);

        $this->assertFalse($lot->isStarted());

        $this->expectException(Throwable::class);
        $this->expectExceptionMessage('Аукцион бошлана олмайди');

        $this->lotService->startLot($lot);
    }

    public function test_lot_cannot_start_because_of_status()
    {
        $lot = Lot::factory()->create([
            'starts_at' => now()->subMinute(),
            'ends_at' => now()->addMinutes(20),
        ]);
        $this->addUserApplicationsToLot($lot);

        $this->lotService->startLot($lot);

        $this->expectException(Throwable::class);
        $this->expectExceptionMessage('Аукцион аллақачон бошланган');

        $this->lotService->startLot($lot);
    }

    public function test_lot_started()
    {
        $lot = Lot::factory()->create([
            'starts_at' => now()->addSeconds(10),
            'ends_at' => now()->addMinutes(20),
        ]);
        $this->addUserApplicationsToLot($lot);

        Carbon::setTestNow(now()->addSeconds(20));
        $this->lotService->startLot($lot);

        $this->assertTrue($lot->isStarted());
    }

    public function test_lot_sms_sent_to_user_after_started(): void
    {
        $lot = Lot::factory()->create([
            'starts_at' => now()->subMinute(),
            'ends_at' => now()->addMinutes(20),
        ]);
        $this->addUserApplicationsToLot($lot);

        $this->smsServiceMock->shouldReceive('sendSms')->times(3);
        $this->lotService->startLot($lot);
    }

    public function test_lot_cannot_end()
    {
        $lot = Lot::factory()->create([
            'starts_at' => now()->subMinute(),
            'ends_at' => now()->addMinutes(20),
        ]);
        $this->addUserApplicationsToLot($lot);

        $this->expectException(Throwable::class);
        $this->expectExceptionMessage('Аукцион тугатила олмайди');

        $this->lotService->endLot($lot);
    }

    public function test_lot_end_with_winner(): void
    {
        $lot = Lot::factory()->create([
            'starts_at' => now()->subMinutes(10),
            'ends_at' => now()->subMinute(),
            'status' => LotStatus::Started,
        ]);
        $this->addUserApplicationsToLot($lot, withSteps: true);

        $this->smsServiceMock->shouldReceive('sendSms')->once();
        $this->lotService->endLot($lot);
        $lot->refresh();

        $this->assertDatabaseHas('lot_users', ['is_winner' => true]);
        $this->assertNotEmpty($lot->payment_deadline);
    }

    public function test_lot_end_without_winner(): void
    {
        $lot = Lot::factory()->create([
            'starts_at' => now()->subMinutes(10),
            'ends_at' => now()->subMinute(),
            'status' => LotStatus::Started,
        ]);
        $this->addUserApplicationsToLot($lot);

        $this->smsServiceMock->shouldNotHaveReceived('sendSms');
        $this->lotService->endLot($lot);

        $this->assertDatabaseMissing('lot_users', ['is_winner' => true]);
        $this->assertDatabaseHas('lots', [
            'id' => $lot->id,
            'payment_deadline' => null
        ]);
    }
}
