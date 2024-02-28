<?php

namespace App\Filament\Resources\TransportResource\Pages;

use App\Models\Transport;
use App\Services\FileService;
use App\Enums\AttachmentType;
use App\Filament\Resources\TransportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class EditTransport extends EditRecord
{
    protected static string $resource = TransportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    // TODO: Write tests for upload and delete Attachments
    protected function afterSave(): void
    {
        $formState = $this->form->getState();
        /** @var Transport $transport */
        $transport = $this->getRecord();

        /** @var (TemporaryUploadedFile|string)[] $mediAttachments */
        $mediaAttachments = $formState['mediaAttachments'] ?? [];
        foreach ($transport->mediaAttachments as $oldMediaAttachment) {
            if (!in_array($oldMediaAttachment->file_path, $mediaAttachments)) {
                $oldMediaAttachment->delete();
            }
        }

        foreach ($mediaAttachments as $attachment) {
            if (is_string($attachment)) continue;
            $attachmentData = FileService::createAttachmentFromFile($attachment);
            $transport->attachments()->create([
                ...$attachmentData,
                'type' => AttachmentType::Media,
            ]);
        }

        /** @var (TemporaryUploadedFile|string)[] $docAttachments */
        $docAttachments = $formState['docAttachments'] ?? [];
        foreach ($transport->docAttachments as $oldDocAttachment) {
            if (!in_array($oldDocAttachment->file_path, $docAttachments)) {
                $oldDocAttachment->delete();
            }
        }

        foreach ($docAttachments as $attachment) {
            if (is_string($attachment)) continue;
            $attachmentData = FileService::createAttachmentFromFile($attachment);
            $transport->attachments()->create([
                ...$attachmentData,
                'type' => AttachmentType::Document,
                'path' => $attachment->store('attachments', 'public'),
            ]);
        }
    }
}
