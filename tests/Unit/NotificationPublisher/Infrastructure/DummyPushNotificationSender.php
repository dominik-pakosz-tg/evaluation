<?php

namespace App\Tests\Unit\NotificationPublisher\Infrastructure;

use App\NotificationPublisher\Infrastructure\Push\PushNotificationMessage;
use App\NotificationPublisher\Infrastructure\Push\PushNotificationSender;

final class DummyPushNotificationSender implements PushNotificationSender
{
    public function send(PushNotificationMessage $message): void
    {
        // test dummy
    }

}
