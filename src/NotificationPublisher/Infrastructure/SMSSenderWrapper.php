<?php

namespace App\NotificationPublisher\Infrastructure;

use App\Entity\Notification;
use App\NotificationPublisher\Infrastructure\SMS\SMSMessage;
use App\NotificationPublisher\Infrastructure\SMS\SMSSender;
use App\Service\UserIdentity;

final class SMSSenderWrapper implements SenderWrapper
{
    private SMSSender $sender;

    public function __construct(SMSSender $sender)
    {
        $this->sender = $sender;
    }

    public function send(UserIdentity $userIdentity, Notification $notification): void
    {
        $message = new SMSMessage($userIdentity->getPhone(), $notification->getText());

        $this->sender->send($message);
    }
}
