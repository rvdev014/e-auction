<?php

namespace App\Services;

use Twilio\Rest\Client;
use Twilio\Exceptions\TwilioException;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Rest\Api\V2010\Account\MessageInstance;

class SmsService
{
    private Client $client;
    private string $fromNumber;

    /**
     * @throws ConfigurationException
     */
    public function __construct()
    {
        $this->client = new Client(
            config('app.twilio.account_sid'),
            config('app.twilio.auth_token')
        );
        $this->fromNumber = config('app.twilio.from');
    }

    /**
     * @throws TwilioException
     */
    public function sendSms(string $phone, string $body): MessageInstance
    {
        return $this->client->messages->create(
            "+$phone",
            [
                'from' => $this->fromNumber,
                'body' => $body,
            ]
        );
    }
}
