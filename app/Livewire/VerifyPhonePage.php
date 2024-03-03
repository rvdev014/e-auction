<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

#[Layout('layouts.auth')]
class VerifyPhonePage extends Component
{
    #[Rule('required|string')]
    public string $verification_code = '';

    public function submitForm()
    {
        $this->validate();

        /** @var User $user */
        $user = Auth::user();

        if ($user->hasVerifiedPhone()) {
            return redirect()->route(RouteServiceProvider::HOME)->with(
                'success',
                'Рақам тасдиқланган'
            );
        }

        if (!$user->verifyCode($this->verification_code)) {
            $this->addError('verification_code', 'Верификация коди нотўғри йоки муддати ўтган');
            return redirect()->route('verify-phone');
        }

        $user->markPhoneAsVerified();
        return redirect()
            ->route(RouteServiceProvider::HOME)
            ->with('success', 'Сизнинг телефон рақамингиз муваффақиятли тасдиқланди');
    }

    public function resend(): void
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
        $user->sendPhoneVerificationNotification();
        session()->flash('success', 'Верификация коди жўнатилди');
        session(['phone_verification_resend' => now()]);
    }
}
