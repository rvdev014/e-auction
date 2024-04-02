<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    public function test_generate_lots_member_number_for_user(): void
    {
        $userData = User::factory()->make();
        $userObj = User::create($userData->getAttributes());

        $user = User::find($userObj->id);

        $this->assertNotEmpty($user->lots_member_number);
        $this->assertEquals(str_pad($user->id, 10, '0', STR_PAD_LEFT), $user->lots_member_number);
    }

    public function test_send_verification_sms(): void
    {
        $newUser = User::factory()->create([
            'phone' => '998901234567',
            'password' => 'password',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $newUser->id,
            'phone' => $newUser->phone,
            'verification_code' => null,
        ]);

        $this->smsServiceMock->shouldReceive('sendSms')->once();
        $newUser->sendPhoneVerificationNotification();
        $newUser->refresh();

        $this->assertNotEmpty($newUser->verification_code);
    }
}
