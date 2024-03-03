<?php

namespace App\Livewire\Components;

use Throwable;
use App\Models\Region;
use Livewire\Component;
use App\Models\District;
use App\Models\UserUpdateRequest;
use Illuminate\Contracts\View\View;
use App\Enums\UserUpdateRequestStatus;

class UserProfileForm extends Component
{
    public int|null $region_id = null;
    public int|null $district_id = null;

    public function onSubmit($formData): void
    {
        try {
            UserUpdateRequest::updateOrCreate([
                'user_id' => auth()->id(),
            ], [
                'data' => [
                    ...$formData,
                    'region_id' => $this->region_id,
                    'district_id' => $this->district_id,
                ],
                'status' => UserUpdateRequestStatus::Pending
            ]);
            session()->flash('success', 'Маълумотлар озгартириш учун суровнома юборилди');
            $this->redirectRoute('user.profile', navigate: true);
        } catch (Throwable $th) {
            session()->flash('error', 'Хатолик юз берди' . $th->getMessage());
        }
    }

    public function updatedRegionId()
    {
        $this->dispatch('regionIdUpdated', $this->region_id);
        $this->reset('district_id');
    }

    public function updatedDistrictId()
    {
        $this->dispatch('regionIdUpdated', $this->region_id);
    }

    public function render(): View
    {
        return view('livewire.components.user-profile-form', [
            'regions' => Region::all(),
            'districts' => District::where('region_id', $this->region_id)->get(),
            'user' => auth()->user(),
        ]);
    }
}
