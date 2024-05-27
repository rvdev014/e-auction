<?php

namespace App\Livewire\Components;

use Throwable;
use App\Models\User;
use App\Models\Region;
use Livewire\Component;
use App\Models\District;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;
use Illuminate\Http\UploadedFile;
use App\Models\UserUpdateRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Enums\UserUpdateRequestStatus;

class UserProfileForm extends Component
{
    use WithFileUploads;

    public int|null $region_id = null;
    public int|null $district_id = null;

    #[Rule(['type' => 'required'])]
    public int|null $type = null;

    #[Rule(['files.*' => 'image'])]
    public $files;

    public function mount(): void
    {
        /** @var User $user */
        $user = auth()->user();
        $this->region_id = $user->region_id;
        $this->district_id = $user->district_id;
        $this->type = $user->type;
    }

    public function render(): View
    {
        return view('livewire.components.user-profile-form', [
            'regions' => Region::all(),
            'districts' => District::where('region_id', $this->region_id)->get(),
            'user' => auth()->user(),
        ]);
    }

    public function onSubmit($formData): void
    {
        DB::beginTransaction();

        try {
            $filesPath = [];
            if (!empty($this->files)) {
                /** @var UploadedFile $file */
                foreach ($this->files as $file) {
                    $filesPath[] = $file->store('user-update-requests', 'public');
                }
            }

            UserUpdateRequest::updateOrCreate([
                'user_id' => auth()->id(),
            ], [
                'data' => [
                    ...$formData,
                    'region_id' => $this->region_id,
                    'district_id' => $this->district_id,
                    'type' => $this->type,
                    'files' => $filesPath
                ],
                'status' => UserUpdateRequestStatus::Pending
            ]);

            /** @var User $currentUser */
            $currentUser = User::where('id', auth()->id())->firstOrFail();

            $formData = array_filter($formData, fn($value) => !empty($value));
            $currentUser->updateOrFail([
                ...$formData,
                'region_id' => $this->region_id,
                'district_id' => $this->district_id,
                'type' => $this->type,
            ]);

            DB::commit();
            session()->flash('success', 'Маълумотлар озгартириш учун суровнома юборилди');
            $this->redirectRoute('user.profile');
        } catch (Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Хатолик юз берди' . $th->getMessage());
        }
    }

    public function updatedRegionId()
    {
        $this->dispatch('regionIdUpdated', $this->region_id);
        $this->reset('district_id');
        $this->district_id = District::where('region_id', $this->region_id)?->first()?->id;
    }

    public function updatedDistrictId()
    {
        $this->dispatch('regionIdUpdated', $this->region_id);
    }
}
