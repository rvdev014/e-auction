<?php

namespace App\Livewire\Components;

use App\Models\User;
use Livewire\Component;
use App\Enums\LotPaymentStatus;
use Illuminate\Contracts\View\View;

class UserWinningReports extends Component
{
    public function render(): View
    {
        /** @var User $user */
        $user = auth()->user();

        return view('livewire.components.user-winning-reports', [
            'reports' => $user->lots()->where('payment_status', LotPaymentStatus::Paid)->get(),
        ]);
    }
}
