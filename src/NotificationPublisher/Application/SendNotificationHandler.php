<?php

namespace App\NotificationPublisher\Application;

use App\Entity\Notification;
use App\NotificationPublisher\Application\Command\SendNotification;
use App\Repository\NotificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class SendNotificationHandler
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(SendNotification $notificationMessage)
    {
        $notification = new Notification();
        $notification->setUserId($notificationMessage->getUserId());
        $notification->setSubject($notificationMessage->getSubject());
        $notification->setText($notificationMessage->getText());
        $notification->setStatus(Notification::STATUS_NEW);
        $notification->setCreatedAt(new \DateTimeImmutable());

        /** @var NotificationRepository $repository */
        $repository = $this->entityManager->getRepository(Notification::class);

        $repository->save($notification, true);
    }
}
