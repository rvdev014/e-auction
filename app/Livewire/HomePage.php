<?php

namespace App\Livewire;

use App\Models\Lot;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class HomePage extends Component
{
    public function render(): View
    {
        return view('livewire.home-page', [
            'lots' => Lot::query()->active()->paginate(10),
        ]);
    }
}
