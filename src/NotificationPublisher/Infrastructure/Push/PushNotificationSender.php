<?php

namespace App\NotificationPublisher\Infrastructure\Push;

interface PushNotificationSender
{
    public function send(PushNotificationMessage $message): void;
}
