<?php

namespace App\Livewire\Components;

use App\Models\Lot;
use App\Models\User;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class UserMessages extends Component
{
    public function render(): View
    {
        /** @var User $user */
        $user = auth()->user();

        return view('livewire.components.user-messages', [
            'messages' => $user->messages,
        ]);
    }
}
