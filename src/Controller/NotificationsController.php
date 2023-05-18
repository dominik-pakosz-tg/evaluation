<?php

namespace App\Controller;

use App\NotificationPublisher\Application\Command\SendNotification;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

class NotificationsController
{
    public function create(MessageBusInterface $bus): Response
    {
        // This is just for sake of testing
        $bus->dispatch(new SendNotification(12, 'Important notification', 'Please check your app!'));

        return new Response('OK');
    }
}
