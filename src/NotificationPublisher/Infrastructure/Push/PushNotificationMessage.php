<?php

namespace App\NotificationPublisher\Infrastructure\Push;

final readonly class PushNotificationMessage
{
    private string $token;
    private string $text;
    private string $subject;

    public function __construct(string $token, string $text, string $subject = '')
    {
        $this->token = $token;
        $this->text = $text;
        $this->subject = $subject;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }
}
