<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
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
