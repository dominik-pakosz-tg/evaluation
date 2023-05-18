<?php

namespace App\NotificationPublisher\Infrastructure\Push;

use App\NotificationPublisher\Infrastructure\Push\Pushy\PushyAPIClient;

final class PushySender implements PushNotificationSender
{
    private PushyAPIClient $client;

    public function __construct(PushyAPIClient $client)
    {
        $this->client = $client;
    }

    public function send(PushNotificationMessage $message): void
    {
        $data = ['message' => $message->getText()];

        // The recipient device tokens
        $to = [$message->getToken()];

        $options = [
            'notification' => [
                'title' => $message->getSubject(),
                'body' => $message->getText(),
            ],
        ];

        // Send it with Pushy
        $this->client->sendPushNotification($data, $to, $options);
    }
}
