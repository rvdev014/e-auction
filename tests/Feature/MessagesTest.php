<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Lot;
use App\Models\User;
use App\Models\Message;
use App\Enums\LotStatus;
use App\Models\LotUserStep;
use App\Services\LotService;
use App\Services\AuthService;
use Tests\Helpers\LotsTestHelper;

class MessagesTest extends TestCase
{
    use LotsTestHelper;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_message_after_register(): void
    {
        /** @var User $newUser */
        $newUser = User::factory()->create([
            'phone' => '998901234567',
            'password' => 'password',
            'verification_code' => $verificationCode = '123456',
        ]);

        app(AuthService::class)->verify($newUser);

        $this->assertDatabaseHas('users', [
            'id' => $newUser->id,
            'verification_code' => null
        ]);
        $this->assertDatabaseHas('messages', [
            'title' => 'Телефон рақам тасдиқланди',
            'user_id' => $newUser->id,
        ]);
    }

    public function test_message_after_lot_applied()
    {
        /** @var Lot $lot */
        $lot = Lot::factory()->create();
        $user = User::factory()->create();

        $this->smsServiceMock->shouldReceive('sendSms')->once();

        $this->actingAs($user);
        app(LotService::class)->applyLot($lot);

        $this->assertDatabaseHas('lot_users', [
            'lot_id' => $lot->id,
            'user_id' => $user->id,
        ]);
        $this->assertDatabaseHas('messages', [
            'title' => 'Лотга ариза кабул килинди',
            'user_id' => $user->id,
        ]);
    }

    public function test_message_after_lot_started()
    {
        /** @var Lot $lot */
        $lot = Lot::factory()->create([
            'starts_at' => now()->subMinute(),
        ]);
        $this->addUserApplicationsToLot($lot, $usersCount = 5);

        $this->smsServiceMock->shouldReceive('sendSms')->times($usersCount);
        app(LotService::class)->startLot($lot);

        $this->assertDatabaseCount('lot_users', $usersCount);
        $this->assertDatabaseCount('messages', $usersCount);
    }

    public function test_message_after_lot_ended()
    {
        /** @var Lot $lot */
        $lot = Lot::factory()->create([
            'starts_at' => now()->subMinutes(5),
            'status' => LotStatus::Started,
        ]);
        $this->addUserApplicationsToLot($lot, $usersCount = 5, true);

        Carbon::setTestNow(now()->addMinutes(10));

        $this->smsServiceMock->shouldReceive('sendSms')->once();
        app(LotService::class)->endLot($lot);

        $this->assertDatabaseCount('lot_users', $usersCount);
        $this->assertDatabaseCount('messages', 1);
        $this->assertDatabaseHas('messages', [
            'title' => "#$lot->number рақамли лотда г'олиб бўлдингиз",
            'user_id' => $lot->winner->user_id,
        ]);
    }
}
