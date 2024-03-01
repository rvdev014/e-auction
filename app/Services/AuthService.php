<?php

namespace App\Services;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class AuthService
{
    public function __construct(
        private readonly SmsService $smsService
    ) {}

    /**
     * @throws Exception
     */
    public function register(array $data): Model|User
    {
        $phone = $data['phone'];
        $password = $data['password'];

        // check if user with this phone already exists
        if (User::where('phone', $phone)->exists()) {
            throw new Exception('User with this phone already exists');
        }

        $verificationCode = rand(1000, 9999);
        $user = User::create([
            'phone' => $phone,
            'password' => Hash::make($password),
            'verification_code' => $verificationCode,
        ]);

        //        $this->smsService->sendSms($phone, $verificationCode);

        return $user;
    }

    /**
     * @throws Exception
     */
    public function login(array $data): Authenticatable
    {
        $phone = $data['phone'];
        $password = $data['password'];

        if (!Auth::attempt(['phone' => $phone, 'password' => $password])) {
            throw new Exception('Invalid credentials');
        }

        return Auth::user();
    }
}
