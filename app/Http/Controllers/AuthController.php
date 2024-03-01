<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    ) {}

    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required'
        ]);

        try {
            $this->authService->login($request->all());
            return redirect()->intended('home');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function showRegisterForm(): View
    {
        return view('auth.register');
    }


    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'phone' => 'required|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ]);

        try {
            $this->authService->register($request->all());
            return redirect()->route('verify')->with('success', 'You have been registered successfully');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function showVerifyForm(User $user): View
    {
        return view('auth.verify', compact('user'));
    }

    public function verify(User $user, Request $request): RedirectResponse
    {
        $request->validate(['verification_code' => 'required']);
        if (!$user->verifyCode($request->input('verification_code'))) {
            return back()->with('error', 'Invalid verification code');
        }
        return redirect()->route('login')->with('success', 'You have been verified successfully');
    }
}
