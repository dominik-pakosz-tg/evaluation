<?php

namespace App\NotificationPublisher\Infrastructure;

use App\Entity\Notification;
use App\NotificationPublisher\Infrastructure\Push\PushNotificationMessage;
use App\NotificationPublisher\Infrastructure\Push\PushNotificationSender;
use App\Service\UserIdentity;

final class PushNotificationSenderWrapper implements SenderWrapper
{
    private PushNotificationSender $sender;

    public function __construct(PushNotificationSender $sender)
    {
        $this->sender = $sender;
    }

    public function send(UserIdentity $userIdentity, Notification $notification): void
    {
        $message = new PushNotificationMessage($userIdentity->getAppToken(), $notification->getText(), $notification->getSubject());

        $this->sender->send($message);
    }
}
