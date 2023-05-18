<?php

namespace App\NotificationPublisher\Infrastructure;

use App\Entity\Notification;
use App\Service\UserIdentity;

interface SenderWrapper
{
    public function send(UserIdentity $userIdentity, Notification $notification): void;
}
