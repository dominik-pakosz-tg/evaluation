<?php

namespace App\NotificationPublisher\Infrastructure\SMS;

final readonly class SMSMessage
{
    private string $number;

    private string $text;

    public function __construct(string $number, string $text)
    {
        $this->number = $number;
        $this->text = $text;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
