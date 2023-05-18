<?php

namespace App\Tests\Unit\NotificationPublisher\Infrastructure;

use App\Entity\Notification;
use App\NotificationPublisher\Infrastructure\Email\EmailMessage;
use App\NotificationPublisher\Infrastructure\Email\EmailSender;
use App\NotificationPublisher\Infrastructure\EmailSenderWrapper;
use App\NotificationPublisher\Infrastructure\Push\PushNotificationMessage;
use App\NotificationPublisher\Infrastructure\Push\PushNotificationSender;
use App\NotificationPublisher\Infrastructure\PushNotificationSenderWrapper;
use App\Service\UserIdentity;
use PHPUnit\Framework\TestCase;

class PushNotificationSenderWrapperTest extends TestCase
{
    public function testPushNotificationSenderWrapper(): void
    {
        $faker = \Faker\Factory::create();

        $userId = $faker->numberBetween();
        $subject = $faker->sentence();
        $text =  $faker->sentence();
        $token = $faker->sha256();

        $pushSenderMock = $this->createMock(PushNotificationSender::class);
        $pushSenderMock->expects($this->once())
            ->method('send')
            ->with($this->callback(function(PushNotificationMessage $pushMessage) use ($subject, $text, $token) {
                return $pushMessage->getToken() === $token && $pushMessage->getText() === $text && $pushMessage->getSubject() === $subject;
            }));

        $testSubject = new PushNotificationSenderWrapper($pushSenderMock);

        $userIdentity = $this->createMock(UserIdentity::class);
        $userIdentity->expects($this->once())
            ->method('getAppToken')
            ->willReturn($token);

        $notification = new Notification();
        $notification->setUserId($userId);
        $notification->setText($text);
        $notification->setSubject($subject);
        $notification->setStatus(Notification::STATUS_NEW);

        $testSubject->send($userIdentity, $notification);
    }
}
