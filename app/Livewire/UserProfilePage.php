<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Auth;

class UserProfilePage extends Component
{
    #[Url(keep: true)]
    public string $tab = 'form';

    public function setTab($tab): void
    {
        $this->tab = $tab;
    }

    public function render()
    {
        return view('livewire.user-profile-page', [
            'user' => Auth::user(),
        ]);
    }
}
