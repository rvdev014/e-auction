<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\GuzzleException;

class SmsService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('app.sms.api.url'),
            'auth' => [config('app.sms.api.username'), config('app.sms.api.password')],
        ]);
    }

    /**
     * @throws GuzzleException
     */
    public function sendSms(string $phone, string $body)
    {
        if (config('app.env') === 'local') {
            Log::channel('sms')->info('SMS sent to ' . $phone . ' with body: ' . $body);
            return ['status' => 'success'];
        }

        $response = $this->client->post('send', [
            'json' => [
                'messages' => [
                    [
                        'recipient' => $phone,
                        'message-id' => 'abc000000001',
                        'sms' => [
                            'originator' => '3700',
                            'content' => [
                                'text' => $body
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
