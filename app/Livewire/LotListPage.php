<?php

namespace App\Livewire;

use App\Models\Lot;
use Livewire\Component;
use App\Enums\LotStatus;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Illuminate\Contracts\View\View;

class LotListPage extends Component
{
    use WithPagination;

    #[Url]
    public LotStatus $status;

    public function render(): View
    {
        $lotsQuery = Lot::query();

        $lots = match ($this->status) {
            LotStatus::Active => $lotsQuery->active()->paginate(10),
            LotStatus::Ended => $lotsQuery->ended()->paginate(10),
            LotStatus::Cancelled => $lotsQuery->cancelled()->paginate(10),
        };

        return view('livewire.lot-list-page', [
            'lots' => $lots,
        ]);
    }
}
