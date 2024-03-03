<?php

namespace App\Interfaces;

interface MustVerifyPhone
{
    public function hasVerifiedPhone(): bool;

    public function markPhoneAsVerified(): bool;

    public function sendPhoneVerificationNotification(): void;
}
