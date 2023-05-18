<?php

namespace App\Tests\Unit\NotificationPublisher\Infrastructure;

use App\NotificationPublisher\Infrastructure\Email\EmailMessage;
use App\NotificationPublisher\Infrastructure\Email\EmailSender;

final class DummyEmailSender implements EmailSender
{
    public function send(EmailMessage $message): void
    {
        // test dummy
    }

}
