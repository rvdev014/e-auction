<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use Exception;
use App\Models\User;
use App\Models\Message;
use App\Enums\PaymentType;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PaymentResource;
use Illuminate\Validation\ValidationException;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;

    /**
     * @throws ValidationException
     */
    protected function beforeValidate(): void
    {
        $formState = $this->form->getState();

        $user = User::find($formState['user_id']);
        if ($user->balance < $formState['amount'] && $formState['type'] == PaymentType::Expense->value) {
            Notification::make()
                ->title('Балансда миқдор кам')
                ->danger()
                ->send();

            throw ValidationException::withMessages(['amount' => 'Балансда миқдор кам']);
        }

        try {
            if ($formState['type'] == 1) {
                $user->balance += $formState['amount'];
            } else {
                $user->balance -= $formState['amount'];
            }

            $user->save();
        } catch (Exception $e) {
            Notification::make()
                ->title('Хатолик юз берди: ' . $e->getMessage())
                ->danger()
                ->send();

            throw ValidationException::withMessages(['amount' => 'Балансда миқдор кам']);
        }
    }

    protected function afterCreate(): void
    {
        $formState = $this->form->getState();
        $amount = $formState['amount'];
        $paymentType = PaymentType::tryFrom($formState['type'])->getLabel();

        Message::create([
            'user_id' => $this->form->getState()['user_id'],
            'title' => 'Тўлов амалга оширилди',
            'body' => "$amount сўм миқдорда $paymentType тўлов амалга оширилди. " . $formState['comment'],
        ]);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
