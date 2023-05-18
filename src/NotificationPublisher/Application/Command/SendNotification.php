<?php

namespace App\NotificationPublisher\Application\Command;

final class SendNotification
{
    public function __construct(
        private readonly int $userId,
        private readonly string $subject,
        private readonly string $text
    ) {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
