<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class FileService
{
    public function storeFile(
        UploadedFile $file,
        string $path,
        string $disk = 'public'
    ): string {
        return $file->store($path, $disk);
    }

    public static function createAttachmentFromFile(TemporaryUploadedFile $file): array
    {
        return [
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $file->store('attachments', 'public'),
            'file_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
        ];
    }
}
