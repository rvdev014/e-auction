<?php

namespace App\Interfaces;

interface MustVerifyPhone
{
    /** Determine if the user has verified their phone. */
    public function hasVerifiedPhone(): bool;

    /** Mark the given user's phone as verified. */
    public function markPhoneAsVerified(): bool;

    /** Send the phone verification notification. */
//    public function sendPhoneVerificationNotification(): void;

    /** Get the phone that should be used for verification */
    public function getPhoneForVerification(): string;
}
