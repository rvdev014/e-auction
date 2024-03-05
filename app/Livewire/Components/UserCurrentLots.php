<?php

namespace App\Livewire\Components;

use App\Models\Lot;
use App\Models\User;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class UserCurrentLots extends Component
{
    public function render(): View
    {
        /** @var User $user */
        $user = auth()->user();
        $lots = Lot::query()
            ->with([
                'latestStep' => fn ($query) => $query->where('user_id', $user->id),
            ])
            ->whereHas('steps', fn (Builder $query) => $query->where('user_id', $user->id))
            ->get();


        return view('livewire.components.user-current-lots', [
            'lots' => $lots,
        ]);
    }
}
