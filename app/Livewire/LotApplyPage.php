<?php

namespace App\Livewire;

use Throwable;
use App\Models\Lot;
use Livewire\Component;
use App\Services\LotService;
use Illuminate\Contracts\View\View;

class LotApplyPage extends Component
{
    private readonly LotService $lotService;
    public Lot $lot;
    public bool $isApproved = false;

    public function boot(LotService $lotService): void
    {
        $this->lotService = $lotService;
    }

    public function onApply(): void
    {
        if (!$this->isApproved) {
            $this->addError('isApproved', 'Оммавий офертани кабул килишингиз керак');
            return;
        }

        try {
            $this->lotService->applyLot($this->lot);
            session()->flash('success', 'Лотга аризангиз кабул килинди');
            $this->redirectRoute('lot.details', ['lot' => $this->lot->id], navigate: true);
        } catch (Throwable $e) {
            $this->addError('isApproved', $e->getMessage());
        }
    }

    public function render(): View
    {
        return view('livewire.lot-apply-page');
    }
}
