<?php

namespace App\Observers;

use App\Enums\PaymentType;
use App\Models\Payment;

class PaymentObserver
{
    /**
     * Handle the Payment "created" event.
     */
    public function created(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "updated" event.
     */
    public function updated(Payment $payment): void
    {
        $user = $payment->user;
        if ($payment->isDirty('amount')) {
            if ($payment->getOriginal('type') == PaymentType::Income) {
                $user->decrement('balance', $payment->getOriginal('amount'));
            } else {
                $user->increment('balance', $payment->getOriginal('amount'));
            }

            if ($payment->type == PaymentType::Income) {
                $user->increment('balance', $payment->amount);
            } else {
                $user->decrement('balance', $payment->amount);
            }
        }
    }

    /**
     * Handle the Payment "deleted" event.
     */
    public function deleted(Payment $payment): void
    {
        $user = $payment->user;
        if ($payment->type == PaymentType::Income) {
            $user->decrement('balance', $payment->amount);
        } else {
            $user->increment('balance', $payment->amount);
        }
    }

    /**
     * Handle the Payment "restored" event.
     */
    public function restored(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "force deleted" event.
     */
    public function forceDeleted(Payment $payment): void
    {
        //
    }
}
