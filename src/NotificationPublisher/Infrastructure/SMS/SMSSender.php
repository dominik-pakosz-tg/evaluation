<?php

namespace App\NotificationPublisher\Infrastructure\SMS;

interface SMSSender
{
    public function send(SMSMessage $message): void;
}
