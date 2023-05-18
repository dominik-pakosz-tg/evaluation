<?php

namespace App\NotificationPublisher\Infrastructure;

use App\Entity\Notification;
use App\Repository\NotificationRepository;
use App\Service\UserIdentity;
use Doctrine\ORM\EntityManagerInterface;

class NotificationDispatcher
{
    public function __construct(private readonly EntityManagerInterface $entityManager, private readonly array $senders)
    {
    }

    public function dispatch(UserIdentity $userIdentity, Notification $notification): void
    {
        $sent = false;
        foreach ($this->senders as $sender) {
            try {
                $sender->send($userIdentity, $notification);
                $sent = true;
            } catch (\Exception $e) {
                // logging here, maybe disable endpoint after few failures
            }

            if ($sent) {
                break;
            }
        }

        if (!$sent) {
            // handle unset message, so something to retry it, but not block other messages

            return;
        }

        $notification->setStatus(Notification::STATUS_SENT);

        /** @var NotificationRepository $repository */
        $repository = $this->entityManager->getRepository(Notification::class);

        $repository->save($notification, true);
    }
}
