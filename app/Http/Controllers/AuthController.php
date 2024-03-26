<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Services\AuthService;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    ) {}

    public function login(AuthRequest $request): RedirectResponse
    {
        try {
            $this->authService->login($request->all());
            return redirect()->intended();
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function register(AuthRequest $request): RedirectResponse
    {
        try {
            $user = $this->authService->register($request->all());
            Auth::login($user);
            return redirect()->route('verify-phone')->with('success', 'Рўйхатдан ўтиш учун телефон рақамингизни тасдиқланг');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function verify(AuthRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        if ($user->hasVerifiedPhone()) {
            return redirect()->route(RouteServiceProvider::HOME)->with('success', 'Рақам тасдиқланган');
        }

        if (!$user->verifyCode($request->input('verification_code'))) {
            return back()->with('error', 'Верификация коди нотўғри йоки муддати ўтган');
        }

        $user->markPhoneAsVerified();

        return redirect()->route(RouteServiceProvider::HOME)->with('success', 'Сизнинг телефон рақамингиз муваффақиятли тасдиқланди');
    }

    public function resend(): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();
        try {
            $user->sendPhoneVerificationNotification();
            return back()->with('success', 'Верификация коди жўнатилди');
        } catch (Exception $e) {
            logger()->error($e);
            return back()->with('error', 'Верификация коди жўнатишда хатолик юз берди');
        }
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
