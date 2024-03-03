<?php

namespace App\Livewire;

use App\Models\Lot;
use Livewire\Component;
use App\Models\LotUser;
use Illuminate\Contracts\View\View;

class LotDetailsPage extends Component
{
    public Lot $lot;

    public function render(): View
    {
        $lotUserExists = LotUser::query()
            ->where('lot_id', $this->lot->id)
            ->where('user_id', auth()->id())
            ->exists();

        return view('livewire.lot-details-page', [
            'isLotApplied' => !$lotUserExists,
            'isLotApplyExpired' => $this->lot->apply_deadline < now()
        ]);
    }
}
