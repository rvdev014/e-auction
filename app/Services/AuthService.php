<?php

namespace App\Services;

use Exception;
use Throwable;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class AuthService
{
    /**
     * @throws Exception
     */
    public function register(array $data): Model|User
    {
        $phone = $data['phone'];
        $password = $data['password'];

        if (User::where('phone', $phone)->exists()) {
            throw new Exception('User with this phone already exists');
        }

        $user = User::create([
            'phone' => $phone,
            'password' => Hash::make($password),
        ]);

        try {
            $user->sendPhoneVerificationNotification();
        } catch (Throwable $e) {
            logger()->error($e);
        }

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
            throw new Exception('Телефон рақам ёки парол нотўғри');
        }

        return Auth::user();
    }

    public function verify(User $user): void
    {
        $user->markPhoneAsVerified();
        $user->messages()->create([
            'title' => 'Телефон рақам тасдиқланди',
            'body' => 'Сизнинг телефон рақамингиз муваффақиятли тасдиқланди',
        ]);
    }

}
