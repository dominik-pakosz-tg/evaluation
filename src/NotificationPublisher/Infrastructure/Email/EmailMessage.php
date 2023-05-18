<?php

namespace App\NotificationPublisher\Infrastructure\Email;

final readonly class EmailMessage
{
    private string $email;
    private string $text;
    private string $subject;

    public function __construct(string $email, string $text, string $subject)
    {
        $this->email = $email;
        $this->text = $text;
        $this->subject = $subject;
    }

    public function getEmail(): string
    {
        return $this->email;
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
