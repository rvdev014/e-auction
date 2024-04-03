<?php

namespace App\Livewire;

use Throwable;
use App\Models\Lot;
use Livewire\Component;
use App\Services\LotService;
use Illuminate\Contracts\View\View;

class LotApplyPage extends Component
{
    public Lot $lot;
    public bool $isApproved = false;

    public function onApply(): void
    {
        if (!$this->isApproved) {
            $this->addError('isApproved', 'Оммавий офертани кабул килишингиз керак');
            return;
        }

        if ($this->lot->apply_deadline->isPast()) {
            $this->addError('isApproved', 'Ариза кабул килиш муддати ўтган');
            return;
        }

        try {
            app(LotService::class)->applyLot($this->lot);
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
