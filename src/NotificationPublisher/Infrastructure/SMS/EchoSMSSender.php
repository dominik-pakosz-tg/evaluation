<?php

namespace App\NotificationPublisher\Infrastructure\SMS;

final class EchoSMSSender implements SMSSender
{
    public function send(SMSMessage $message): void
    {
        echo 'EchoSMSSender'.PHP_EOL;
        echo $message->getText().PHP_EOL;
        echo $message->getNumber().PHP_EOL;
        echo PHP_EOL;
    }
}
