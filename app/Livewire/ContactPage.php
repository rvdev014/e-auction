<?php

namespace App\Livewire;

use Exception;
use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Log;
use App\Providers\RouteServiceProvider;
use GuzzleHttp\Exception\GuzzleException;

class ContactPage extends Component
{
    #[Validate('required|string')]
    public string $name = '';

    #[Validate('required|string|email|max:100')]
    public string $email = '';

    #[Validate('required|string|max:255')]
    public string $subject = '';

    public function submitForm(): void
    {
        $this->validate();

        try {
            $botToken = config('app.telegram.token');
            $tgBaseUrl = config('app.telegram.base_url');
            $chatId = config('app.telegram.group_id');

            $text = "<b>Сайтдан янги Мурожаат!</b>\n\n";
            $text .= "<b>Исм:</b> $this->name\n";
            $text .= "<b>E-mail:</b> $this->email\n";
            $text .= "<b>Мавзу:</b> {$this->subject}\n";

            $url = "$tgBaseUrl/bot$botToken/sendMessage";
            $client = new Client();
            $client->post($url, [
                'json' => [
                    'chat_id' => $chatId,
                    'text' => $text,
                    'parse_mode' => 'HTML',
                ]
            ]);
        } catch (GuzzleException $e) {
            Log::error($e->getMessage());
            session()->flash('error', 'Формани юборишда хатолик юз берди. Илтимос, қайта уриниб кўринг.');
            return;
        }

        session()->flash('success', 'Мурожаатингиз қабул қилинди. Тез орада сиз билан боғланишади.');
        $this->redirectIntended(route(RouteServiceProvider::HOME), navigate: true);
    }
}
