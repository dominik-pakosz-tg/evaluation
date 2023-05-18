<?php

namespace App\NotificationPublisher\Infrastructure;

use App\Entity\Notification;
use App\NotificationPublisher\Infrastructure\Email\EmailMessage;
use App\NotificationPublisher\Infrastructure\Email\EmailSender;
use App\Service\UserIdentity;

final class EmailSenderWrapper implements SenderWrapper
{
    private EmailSender $sender;

    public function __construct(EmailSender $sender)
    {
        $this->sender = $sender;
    }

    public function send(UserIdentity $userIdentity, Notification $notification): void
    {
        $message = new EmailMessage($userIdentity->getEmail(), $notification->getText(), $notification->getSubject());

        $this->sender->send($message);
    }
}
