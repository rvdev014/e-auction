<?php

namespace App\Filament\Resources\UserUpdateRequestResource\Pages;

use Throwable;
use Filament\Forms;
use App\Models\User;
use App\Models\Region;
use Filament\Forms\Form;
use App\Models\District;
use Filament\Actions\Action;
use App\Services\FileService;
use App\Enums\AttachmentType;
use Illuminate\Support\Facades\Storage;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\File\File;
use App\Filament\Resources\UserUpdateRequestResource;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class EditUserUpdateRequest extends EditRecord
{
    protected static string $resource = UserUpdateRequestResource::class;

    protected function beforeSave(): void
    {
        $formState = $this->form->getState();

        try {
            /** @var User $user */
            $user = User::find($this->record->user_id);
            $user->updateOrFail($formState);

            /** @var (TemporaryUploadedFile|string)[] $files */
            $files = $formState['files'] ?? [];
            if (!empty($files)) {
                foreach ($user->attachments as $oldAttachment) {
                    if (!in_array($oldAttachment->file_path, $oldAttachment)) {
                        $oldAttachment->delete();
                    }
                }

                foreach ($files as $file) {
                    if (is_string($file)) {
                        $existedFile = new File(Storage::disk('public')->path($file));
                        $attachmentData = [
                            'file_name' => $existedFile->getFilename(),
                            'file_path' => $file,
                            'file_type' => $existedFile->getMimeType(),
                            'file_size' => $existedFile->getSize(),
                        ];
                    } else {
                        $attachmentData = FileService::createAttachmentFromFile($file);
                    }

                    $user->attachments()->create([
                        ...$attachmentData,
                        'type' => AttachmentType::Document,
                    ]);
                }
            }

            Notification::make()
                ->title('Фойдаланувчи маълумотлари муваффақиятли янгиланди')
                ->success()
                ->send();

        } catch (Throwable $e) {
            Notification::make()
                ->title('Хатолик юз берди: ' . $e->getMessage())
                ->danger()
                ->send();

            throw ValidationException::withMessages([
                'error' => 'Хатолик юз берди: ' . $e->getMessage(),
            ]);
        }
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('cancel')
                ->label('Бекор килиш')
                ->requiresConfirmation()
                ->color('danger')
                ->action(function() {
                    $this->record->delete();
                    return redirect()->route('filament.admin.resources.user-update-requests.index');
                }),

            Action::make('save')
                ->label('Кабул килиш')
                ->requiresConfirmation()
                ->color('success')
                ->submit('save'),
        ];
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('user_id')
                ->label('Фойдаланувчи')
                ->formatStateUsing(function($record) {
                    return $record->user->name ?? $record->user->phone;
                })
                ->readOnly()
                ->required(),

            Forms\Components\TextInput::make('name')
                ->label('Фамилия Исм Шарифи')
                ->formatStateUsing(function($record) {
                    return $record->data->get('name');
                }),

            Forms\Components\TextInput::make('email')
                ->readOnly()
                ->label('Электрон почта')
                ->formatStateUsing(function($record) {
                    return $record->data->get('email');
                }),

            Forms\Components\DatePicker::make('birth_date')
                ->label('Туғилган кун')
                ->formatStateUsing(function($record) {
                    return $record->data->get('birth_date');
                }),

            Forms\Components\TextInput::make('stir')
                ->label('СТИР')
                ->formatStateUsing(function($record) {
                    return $record->data->get('stir');
                }),

            Forms\Components\Select::make('type')
                ->label('Жисмоний/Юридик шахс')
                ->options([
                    '1' => 'Жисмоний шахс',
                    '2' => 'Юридик шахс',
                ])
                ->formatStateUsing(function($record) {
                    return $record->data->get('type');
                }),

            Forms\Components\TextInput::make('address')
                ->label('Манзил')
                ->formatStateUsing(function($record) {
                    return $record->data->get('address');
                }),

            Forms\Components\Select::make('region_id')
                ->label('Вилоят/Шаҳар')
                ->options(Region::pluck('name', 'id')->toArray())
                ->formatStateUsing(function($record) {
                    return $record->data->get('region_id');
                }),

            Forms\Components\Select::make('district_id')
                ->label('Туман/Шаҳар')
                ->options(function($record) {
                    return District::where('region_id', $record->data->get('region_id'))->pluck('name', 'id')->toArray(
                    );
                })
                ->formatStateUsing(function($record) {
                    return $record->data->get('district_id');
                }),

            Forms\Components\TextInput::make('passport')
                ->label('Паспорт серия ва рақами')
                ->formatStateUsing(function($record) {
                    return $record->data->get('passport');
                }),

            Forms\Components\DatePicker::make('passport_date')
                ->label('Паспорт берилган сана')
                ->formatStateUsing(function($record) {
                    return $record->data->get('passport_date');
                }),

            Forms\Components\TextInput::make('passport_given')
                ->label('Паспорт берган манзил')
                ->formatStateUsing(function($record) {
                    return $record->data->get('passport_given');
                }),

            Forms\Components\TextInput::make('pinfl')
                ->label('ЖШШИР')
                ->formatStateUsing(function($record) {
                    return $record->data->get('pinfl');
                }),

            Forms\Components\FileUpload::make('files')
                ->label('Файллар')
                ->multiple()
                ->formatStateUsing(function($record) {
                    if (!$record) {
                        return [];
                    }
                    return $record->data->get('files');
                })
                ->storeFiles(false)
                ->columnSpanFull(),
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            //            Actions\DeleteAction::make(),
        ];
    }
}
