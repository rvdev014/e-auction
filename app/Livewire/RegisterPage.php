<?php

namespace App\Livewire;

use Exception;
use Livewire\Component;
use App\Services\AuthService;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.auth')]
class RegisterPage extends Component
{
    #[Rule('required|string')]
    public string $phone = '';

    #[Rule('required|string|min:6|confirmed')]
    public string $password = '';

    public string $password_confirmation  = '';

    private readonly AuthService $authService;
    public function boot(AuthService $authService): void
    {
        $this->authService = $authService;
    }

    public function submitForm(): void
    {
        try {
            $this->validate();
            $user = $this->authService->register([
                'phone' => $this->phone,
                'password' => $this->password,
                'password_confirmation' => $this->password,
            ]);
            Auth::login($user);
            $this->redirectRoute('verify-phone', true);
        } catch (Exception $e) {
            $this->addError('phone', $e->getMessage());
        }
    }
}
