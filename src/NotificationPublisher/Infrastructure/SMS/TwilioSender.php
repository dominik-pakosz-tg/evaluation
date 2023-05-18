<?php

namespace App\NotificationPublisher\Infrastructure\SMS;

use Twilio\Rest\Client;

final class TwilioSender implements SMSSender
{
    private Client $client;
    private readonly string $fromNumber;

    public function __construct(
        Client $client,
        string $fromNumber
    ) {
        $this->client = $client;
        $this->fromNumber = $fromNumber;
    }

    public function send(SMSMessage $message): void
    {
        $this->client->messages->create(
            // Where to send a text message (your cell phone?)
            $message->getNumber(),
            [
                'from' => $this->fromNumber,
                'body' => $message->getText(),
            ]
        );
    }
}
