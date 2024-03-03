<?php

namespace App\Services;

use Exception;
use App\Models\Lot;
use App\Models\LotUser;
use Twilio\Exceptions\TwilioException;

class LotService
{
    public function __construct(private readonly SmsService $smsService)
    {}

    /**
     * @throws Exception
     */
    public function applyLot(Lot $lot): void
    {
        LotUser::create([
            'lot_id' => $lot->id,
            'user_id' => auth()->id(),
        ]);
//        $this->smsService->sendSms('Your application has been accepted', auth()->user()->phone);
    }
}
