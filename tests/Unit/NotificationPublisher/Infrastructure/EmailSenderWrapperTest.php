<?php

namespace App\Tests\Unit\NotificationPublisher\Infrastructure;

use App\Entity\Notification;
use App\NotificationPublisher\Infrastructure\Email\EmailSender;
use App\NotificationPublisher\Infrastructure\EmailSenderWrapper;
use App\Service\UserIdentity;
use PHPUnit\Framework\TestCase;
use App\NotificationPublisher\Infrastructure\Email\EmailMessage;

class EmailSenderWrapperTest extends TestCase
{
    public function testEmailSenderWrapper(): void
    {
        $faker = \Faker\Factory::create();

        $userId = $faker->numberBetween();
        $subject =  $faker->sentence();
        $text =  $faker->sentence();
        $email = $faker->safeEmail();

        $emailSenderMock = $this->createMock(EmailSender::class);
        $emailSenderMock->expects($this->once())
            ->method('send')
            ->with($this->callback(function(EmailMessage $emailMessage) use ($subject, $text, $email) {
                return $emailMessage->getEmail() === $email && $emailMessage->getText() === $text && $emailMessage->getSubject() === $subject;
            }));

        $testSubject = new EmailSenderWrapper($emailSenderMock);

        $userIdentity = $this->createMock(UserIdentity::class);
        $userIdentity->expects($this->once())
            ->method('getEmail')
            ->willReturn($email);

        $notification = new Notification();
        $notification->setUserId($userId);
        $notification->setText($text);
        $notification->setSubject($subject);
        $notification->setStatus(Notification::STATUS_NEW);

        $testSubject->send($userIdentity, $notification);
    }
}
