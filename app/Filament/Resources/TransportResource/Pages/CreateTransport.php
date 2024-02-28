<?php

namespace App\Filament\Resources\TransportResource\Pages;

use App\Models\Transport;
use App\Enums\AttachmentType;
use App\Services\FileService;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\TransportResource;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class CreateTransport extends CreateRecord
{
    protected static string $resource = TransportResource::class;

    protected function afterCreate(): void
    {
        $formState = $this->form->getState();
        /** @var Transport $transport */
        $transport = $this->getRecord();

        /** @var TemporaryUploadedFile[] $mediAttachments */
        $mediaAttachments = $formState['mediaAttachments'] ?? [];
        foreach ($mediaAttachments as $attachment) {
            $attachmentData = FileService::createAttachmentFromFile($attachment);
            $transport->attachments()->create([
                ...$attachmentData,
                'type' => AttachmentType::Media,
            ]);
        }

        /** @var TemporaryUploadedFile[] $docAttachments */
        $docAttachments = $formState['docAttachments'] ?? [];
        foreach ($docAttachments as $attachment) {
            $attachmentData = FileService::createAttachmentFromFile($attachment);
            $transport->attachments()->create([
                ...$attachmentData,
                'type' => AttachmentType::Document,
                'path' => $attachment->store('attachments', 'public'),
            ]);
        }
    }
}
