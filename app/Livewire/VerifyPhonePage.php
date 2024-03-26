<?php

namespace App\Livewire;

use Exception;
use Throwable;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Rule;
use App\Services\AuthService;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

#[Layout('layouts.auth')]
class VerifyPhonePage extends Component
{
    private readonly AuthService $authService;

    #[Rule('required|string')]
    public string $verification_code = '';

    public function boot(AuthService $authService): void
    {
        $this->authService = $authService;
    }

    public function submitForm(): void
    {
        $this->validate();

        /** @var User $user */
        $user = Auth::user();

        if ($user->hasVerifiedPhone()) {
            session()->flash('success', 'Рақам тасдиқланган');
            $this->redirectRoute(RouteServiceProvider::HOME, navigate: true);
            return;
        }

        if (!$user->verifyCode($this->verification_code)) {
            $this->addError('verification_code', 'Верификация коди нотўғри йоки муддати ўтган');
            return;
        }

        $this->authService->verify($user);

        session()->flash('success', 'Сизнинг телефон рақамингиз муваффақиятли тасдиқланди');
        $this->redirectRoute(RouteServiceProvider::HOME, navigate: true);
    }

    public function resend($throwable): void
    {
        // throttle request 2 times per minute
        if (session()->has('phone_verification_resend')) {
            $resend = session('phone_verification_resend');
            if (now()->diffInSeconds($resend) < 60) {
                session()->flash('error', 'Қайта жўнатиш учун кутинг (1 минутда бир марта)');
                return;
            }
        }

        /** @var User $user */
        $user = Auth::user();
        try {
            $user->sendPhoneVerificationNotification();
            session()->flash('success', 'Верификация коди жўнатилди');
            session(['phone_verification_resend' => now()]);
        } catch (Throwable $e) {
            logger()->error($e);
            session()->flash('error', 'Верификация коди жўнатишда хатолик юз берди');
        }
    }
}
