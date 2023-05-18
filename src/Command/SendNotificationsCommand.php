<?php

namespace App\Command;

use App\Entity\Notification;
use App\NotificationPublisher\Infrastructure\NotificationDispatcher;
use App\Repository\NotificationRepository;
use App\Service\UserIdentityProvider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:send-notifications')]
class SendNotificationsCommand extends Command
{
    protected static $defaultDescription = 'Dispatch pending notifications';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserIdentityProvider $identityProvider,
        private readonly NotificationDispatcher $notificationDispatcher
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // TODO: Move from Comamnd to Service or Command/Handler.

        /** @var NotificationRepository $repository */
        $repository = $this->entityManager->getRepository(Notification::class);

        $notifications = $repository->findNotSent();

        foreach ($notifications as $notification) {
            $user = $this->identityProvider->getUserById($notification->getUserId());

            if (!$user) {
                $notification->setStatus(Notification::STATUS_NO_USER);
                $repository->save($notification, true);

                continue;
            }

            $this->notificationDispatcher->dispatch($user, $notification);
        }

        return Command::SUCCESS;
    }
}
