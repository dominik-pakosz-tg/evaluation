<?php

namespace App\Tests\Unit\NotificationPublisher\Infrastructure;

use App\NotificationPublisher\Infrastructure\Email\EmailSender;
use App\NotificationPublisher\Infrastructure\NotificationDispatcher;
use App\NotificationPublisher\Infrastructure\NotificationDispatcherFactory;
use App\NotificationPublisher\Infrastructure\Push\PushNotificationSender;
use App\NotificationPublisher\Infrastructure\SMS\SMSSender;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class NotificationDispatcherFactoryTest extends TestCase
{
    public function testCreatesNotificationDispatcherFactory(): void
    {
        $containerMock = $this->createMock(ContainerInterface::class);
        $containerMock->expects($this->exactly(3))
            ->method('get')
            ->withConsecutive(
                [DummyEmailSender::class],
                [DummyPushNotificationSender::class],
                [DummySMSSender::class]
            )
            ->willReturnOnConsecutiveCalls(
                $this->createMock(EmailSender::class),
                $this->createMock(PushNotificationSender::class),
                $this->createMock(SMSSender::class),
            );
        $entityManagerMock = $this->createMock(EntityManagerInterface::class);

        $testSubject = new NotificationDispatcherFactory(
            $containerMock,
            [
                DummyEmailSender::class,
                DummyPushNotificationSender::class,
                DummySMSSender::class,
            ]
        );

        $service = $testSubject->createNotificationDispatcher($entityManagerMock);

        $this->assertInstanceOf(NotificationDispatcher::class, $service);
    }

    public function testThrowsExceptionOnWrongType(): void
    {
        $containerMock = $this->createMock(ContainerInterface::class);
        $containerMock->expects($this->exactly(1))
            ->method('get')
            ->with(WrongTypeSender::class)
            ->willReturn(
                new WrongTypeSender()
            );
        $entityManagerMock = $this->createMock(EntityManagerInterface::class);

        $testSubject = new NotificationDispatcherFactory(
            $containerMock,
            [
                WrongTypeSender::class,
            ]
        );

        $this->expectException(\Exception::class);
        $service = $testSubject->createNotificationDispatcher($entityManagerMock);
    }
}
