<?php

namespace App\Livewire;

use Exception;
use Livewire\Component;
use Livewire\Attributes\Rule;
use App\Services\AuthService;
use Livewire\Attributes\Layout;
use App\Providers\RouteServiceProvider;

#[Layout('layouts.auth')]
class LoginPage extends Component
{
    #[Rule('required|string')]
    public string $phone = '';

    #[Rule('required|string')]
    public string $password = '';

    public function submitForm(): void
    {
        try {
            $this->validate();
            app(AuthService::class)->login([
                'phone' => $this->phone,
                'password' => $this->password,
            ]);
            $this->redirectIntended(route(RouteServiceProvider::HOME), navigate: true);
        } catch (Exception $e) {
            $this->addError('phone', $e->getMessage());
        }
    }
}
