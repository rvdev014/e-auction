<?php

namespace App\Services;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Twilio\Exceptions\TwilioException;
use Illuminate\Database\Eloquent\Model;

class AuthService
{
    public function __construct(
        private readonly SmsService $smsService
    ) {}

    /**
     * @throws TwilioException
     */
    public function register(array $data): Model|User
    {
        $phone = $data['phone'];
        $password = $data['password'];

        $verificationCode = rand(1000, 9999);
        $user = User::create([
            'phone' => $phone,
            'password' => Hash::make($password),
            'verification_code' => $verificationCode,
        ]);

        $this->smsService->sendSms($phone, $verificationCode);

        return $user;
    }

    /**
     * @throws Exception
     */
    public function login(array $data): Model|User
    {
        $phone = $data['phone'];
        $password = $data['password'];

        $user = User::where('phone', $phone)->firstOrFail();
        if (!password_verify($password, $user->password)) {
            throw new Exception('Invalid credentials');
        }

        return $user;
    }
}
