<?php

namespace App\NotificationPublisher\Infrastructure\Email;

final class EchoEmailSender implements EmailSender
{
    public function send(EmailMessage $message): void
    {
        echo 'EchoEmailSender'.PHP_EOL;
        echo $message->getSubject().PHP_EOL;
        echo $message->getText().PHP_EOL;
        echo $message->getEmail().PHP_EOL;
        echo PHP_EOL;
    }
}
