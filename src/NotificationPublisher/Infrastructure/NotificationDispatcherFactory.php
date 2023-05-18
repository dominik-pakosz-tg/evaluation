<?php

namespace App\NotificationPublisher\Infrastructure;

use App\NotificationPublisher\Infrastructure\Email\EmailSender;
use App\NotificationPublisher\Infrastructure\Push\PushNotificationSender;
use App\NotificationPublisher\Infrastructure\SMS\SMSSender;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

class NotificationDispatcherFactory
{
    public function __construct(private ContainerInterface $container, private array $senderClasses)
    {
    }

    public function createNotificationDispatcher(EntityManagerInterface $entityManager): NotificationDispatcher
    {
        $wrappedSenders = [];
        foreach ($this->senderClasses as $senderClass) {
            $sender = $this->container->get($senderClass);

            if ($sender instanceof SMSSender) {
                $wrappedSenders[] = new SMSSenderWrapper($sender);
            } elseif ($sender instanceof EmailSender) {
                $wrappedSenders[] = new EmailSenderWrapper($sender);
            } elseif ($sender instanceof PushNotificationSender) {
                $wrappedSenders[] = new PushNotificationSenderWrapper($sender);
            } else {
                throw new \Exception('Unsupported sender type');
            }
        }

        return new NotificationDispatcher($entityManager, $wrappedSenders);
    }
}
