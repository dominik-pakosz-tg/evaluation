<?php

namespace App\NotificationPublisher\Infrastructure\Push;

final class EchoPushNotificationSender implements PushNotificationSender
{
    public function send(PushNotificationMessage $message): void
    {
        echo 'EchoPushNotificationSender'.PHP_EOL;
        echo $message->getSubject().PHP_EOL;
        echo $message->getText().PHP_EOL;
        echo $message->getToken().PHP_EOL;
        echo PHP_EOL;
    }
}
