<?php

namespace App\Livewire;

use Throwable;
use App\Models\Lot;
use Livewire\Component;
use App\Models\LotUser;
use App\Enums\LotStatus;
use Livewire\Attributes\On;
use App\Models\LotUserStep;
use App\Services\LotService;
use Livewire\Attributes\Url;
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

    #[Url(keep: true)]
    public string $tab = 'lot-info';

    public function setTab($tab): void
    {
        $this->tab = $tab;
    }

    public function boot(LotService $lotService): void
    {
        $this->lotService = $lotService;
    }

    public function onStep(): void
    {
        try {
            $this->validateOnly('step');

            if (!$this->lot->isStarted()) {
                session()->flash('error', 'Аукцион бошланмаган ёки тугаган');
                $this->redirectRoute('lot.details', ['lot' => $this->lot->id], navigate: true);
                return;
            }

            if ($this->maxPrice > 0 && $this->step <= $this->maxPrice) {
                $this->addError('step', 'Минимум нарх: ' . $this->maxPrice);
                return;
            }

            /** @var LotUser $lotUser */
            $lotUser = $this->lot->lotUsers()->where('user_id', auth()->id())->first();
            $lotUser->steps()->create(['price' => $this->step]);

            $this->reset('step');
            $this->tab = 'lot-step';
        } catch (Throwable $e) {
            $this->addError('step', $e->getMessage());
        }
    }

    #[On('lot_started')]
    public function lotStarted(): void
    {
        try {
            $this->lotService->startLot($this->lot);
            session()->flash('success', 'Аукцион бошланди');
            $this->redirectRoute('lot.details', ['lot' => $this->lot->id], navigate: true);
        } catch (Throwable $e) {
            session()->flash('error', $e->getMessage());
            $this->redirectRoute('lot.details', ['lot' => $this->lot->id], navigate: true);
        }

        if (!$this->lot->isActive()) {
            session()->flash('error', 'Аукцион бошланмади. Иштирокчилар йетарли эмас');
            $this->redirectRoute('lot.details', ['lot' => $this->lot->id], navigate: true);
            return;
        }

        session()->flash('success', 'Аукцион бошланди');
        $this->redirectRoute('lot.details', ['lot' => $this->lot->id], navigate: true);
    }

    #[On('lot_ended')]
    public function lotEnded(): void
    {
        try {
            $this->lotService->endLot($this->lot);
            session()->flash('success', 'Аукцион тугади');
            $this->redirectRoute('lot.details', ['lot' => $this->lot->id], navigate: true);
        } catch (Throwable $e) {
            session()->flash('error', $e->getMessage());
            $this->redirectRoute('lot.details', ['lot' => $this->lot->id], navigate: true);
        }
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
