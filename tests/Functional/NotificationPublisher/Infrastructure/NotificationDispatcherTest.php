<?php

namespace App\Tests\Functional\NotificationPublisher\Infrastructure;

use App\Entity\Notification;
use App\NotificationPublisher\Infrastructure\NotificationDispatcher;
use App\NotificationPublisher\Infrastructure\SenderWrapper;
use App\Repository\NotificationRepository;
use App\Service\UserIdentity;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Generator;
use \Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class NotificationDispatcherTest extends KernelTestCase
{
    private readonly Generator $faker;

    private readonly EntityManagerInterface $entityManager;

    private readonly NotificationRepository $repository;
    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $this->faker = Factory::create();

        $this->entityManager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->entityManager->getRepository(Notification::class);
    }

    public function testItMarksNotificationAsSent(): void
    {
        $userIdentityMock = $this->createMock(UserIdentity::class);

        $notification = $this->setUpNotification();

        $wrapperMock = $this->createMock(SenderWrapper::class);
        $wrapperMock->expects($this->once())
            ->method('send')
            ->with($userIdentityMock, $notification);

        $subject = new NotificationDispatcher($this->entityManager, [
            $wrapperMock
        ]);

        $subject->dispatch($userIdentityMock, $notification);

        $notification = $this->repository->find($notification->getId());

        $this->assertSame(Notification::STATUS_SENT, $notification->getStatus());
    }

    public function testDoesNothingIfMessageNotSent(): void
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = static::getContainer()->get('doctrine')->getManager();

        $userIdentityMock = $this->createMock(UserIdentity::class);

        $notification = $this->setUpNotification();


        $wrapperMock = $this->createMock(SenderWrapper::class);
        $wrapperMock->expects($this->once())
            ->method('send')
            ->willThrowException(new \Exception());

        $subject = new NotificationDispatcher($entityManager, [
            $wrapperMock
        ]);

        $subject->dispatch($userIdentityMock, $notification);

        $notification = $this->repository->find($notification->getId());

        $this->assertSame(Notification::STATUS_NEW, $notification->getStatus());
    }

    private function setUpNotification(): Notification
    {
        $notification = new Notification();
        $notification->setUserId(12);
        $notification->setStatus(Notification::STATUS_NEW);
        $notification->setSubject($this->faker->sentence());
        $notification->setText($this->faker->sentence());
        $notification->setCreatedAt(new \DateTimeImmutable());

        $this->repository->save($notification, true);

        return $notification;
    }
}
