<?php

namespace App\Tests\Unit\NotificationPublisher\Infrastructure;

use App\NotificationPublisher\Infrastructure\SMS\SMSMessage;
use App\NotificationPublisher\Infrastructure\SMS\SMSSender;

final class DummySMSSender implements SMSSender
{
    public function send(SMSMessage $message): void
    {
        // test dummy
    }

}
