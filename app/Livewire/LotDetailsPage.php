<?php

namespace App\Livewire;

use App\Models\Lot;
use App\Models\User;
use Livewire\Component;
use App\Enums\LotStatus;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Illuminate\Contracts\View\View;

class LotDetailsPage extends Component
{
    #[Rule('required|integer')]
    public int $step;

    public Lot $lot;

    #[On('lot_started')]
    public function lotStarted(): void
    {
        session()->flash('success', 'Аукцион бошланди');
        $this->redirectRoute('lot.details', ['lot' => $this->lot->id], navigate: true);
    }

    #[On('lot_ended')]
    public function lotEnded(): void
    {
        $this->lot->update([
            'status' => LotStatus::Ended,
        ]);
        session()->flash('success', 'Аукцион тугади');
        $this->redirectRoute('lot.details', ['lot' => $this->lot->id], navigate: true);
    }

    public function onStep(): void
    {
        $this->validateOnly('step');
    }

    public function render(): View
    {
        // FOR TESTING PURPOSES
        /*if ($this->lot->starts_at < now() && $this->lot->ends_at < now()) {
            $this->lot->update([
                'starts_at' => now()->addSeconds(5),
                'status' => LotStatus::Active,
                'ends_at' => now()->addMinutes(20),
            ]);
        }*/

        /** @var User $user */
        $user = auth()->user();
        $lotUserExists = $user->lots()
            ->where('lot_id', $this->lot->id)
            ->exists();

        return view('livewire.lot-details-page', [
            'isLotApplied' => $lotUserExists,
        ]);
    }
}
