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
        $user = User::whereRaw("REPLACE(REPLACE(phone, '+', ''), ' ', '') = ?", [str_replace([' ', '+'], ['', ''], $phone)])->first();

        if ($user && Hash::check($password, $user->password)) {
            // Log in the user
            Auth::login($user);

            // Redirect to the intended page or show a success message
            return Auth::user();
        }

        throw new Exception('Телефон рақам ёки парол нотўғри');
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
