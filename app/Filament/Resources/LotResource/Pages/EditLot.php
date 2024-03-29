<?php

namespace App\Filament\Resources\LotResource\Pages;

use App\Enums\LotPaymentStatus;
use App\Services\PaymentService;
use App\Filament\Resources\LotResource;
use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;

class EditLot extends EditRecord
{
    protected static string $resource = LotResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $oldPaymentStatus = $record->payment_status;
        if ($oldPaymentStatus == LotPaymentStatus::NotPaid && $data['payment_status'] == LotPaymentStatus::Paid->value) {
            $data['reports_at'] = now();
        }

        $record->update($data);

        return $record;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
