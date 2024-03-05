<?php

namespace App\Livewire;

use Throwable;
use App\Models\Lot;
use Livewire\Component;
use App\Enums\LotStatus;
use Livewire\Attributes\On;
use App\Services\LotService;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Computed;
use Illuminate\Contracts\View\View;

/**
 * @property int $maxPrice
 */
class LotDetailsPage extends Component
{
    private readonly LotService $lotService;

    #[Rule('required|integer')]
    public int $step;

    public Lot $lot;

    public function boot(LotService $lotService): void
    {
        $this->lotService = $lotService;
    }

    public function onStep(): void
    {
        try {
            $this->validateOnly('step');

            if (!$this->lotService->isLotActive($this->lot)) {
                session()->flash('error', 'Аукцион тугади');
                $this->redirectRoute('lot.details', ['lot' => $this->lot->id], navigate: true);
                return;
            }

            if ($this->maxPrice > 0 && $this->step <= $this->maxPrice) {
                $this->addError('step', 'Минимум нарх: ' . $this->maxPrice);
                return;
            }

            $this->lot->steps()->updateOrCreate([
                'user_id' => auth()->id(),
                'price' => null,
            ], ['price' => $this->step]);

            $this->dispatch('lot_step', $this->lot->id);
            $this->reset('step');
        } catch (Throwable $e) {
            $this->addError('step', $e->getMessage());
        }
    }

    #[On('lot_started')]
    public function lotStarted(): void
    {
        session()->flash('success', 'Аукцион бошланди');
        $this->redirectRoute('lot.details', ['lot' => $this->lot->id], navigate: true);
    }

    #[On('lot_ended')]
    public function lotEnded(): void
    {
        session()->flash('success', 'Аукцион тугади');
        $this->redirectRoute('lot.details', ['lot' => $this->lot->id], navigate: true);
    }

    #[Computed('maxPrice')]
    public function getMaxPriceProperty(): int
    {
        return $this->lot->steps()->max('price') ?: $this->lot->starting_price;
    }

    public function render(): View
    {
        // FOR TESTING PURPOSES
        /*$this->lot->update([
            'starts_at' => now()->addSeconds(10),
            'status' => LotStatus::Active,
            'ends_at' => now()->addMinutes(20),
        ]);*/

        return view('livewire.lot-details-page');
    }
}
