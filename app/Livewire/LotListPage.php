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
        $lots = Lot::where('status', $this->status)->get();
        return view('livewire.lot-list-page', [
            'lots' => $lots,
        ]);
    }
}
