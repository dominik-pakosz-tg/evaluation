<?php

namespace App\NotificationPublisher\Infrastructure\Email;

interface EmailSender
{
    public function send(EmailMessage $message): void;
}
