<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    ) {}

    public function showLoginForm(): View
    {
        return view('auth.login');
    }


    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        DB::beginTransaction();

        $request->validate([
            'phone' => 'required|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ]);

        try {
            $this->authService->register($request->all());
            DB::rollBack();
            return redirect()->route('login')->with('success', 'You have been registered successfully');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
