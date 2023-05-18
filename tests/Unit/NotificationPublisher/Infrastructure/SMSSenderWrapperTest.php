<?php

namespace App\Tests\Unit\NotificationPublisher\Infrastructure;

use App\Entity\Notification;
use App\NotificationPublisher\Infrastructure\SMS\SMSMessage;
use App\NotificationPublisher\Infrastructure\SMS\SMSSender;
use App\NotificationPublisher\Infrastructure\SMSSenderWrapper;
use App\Service\UserIdentity;
use PHPUnit\Framework\TestCase;

class SMSSenderWrapperTest extends TestCase
{
    public function testSMSSenderWrapper(): void
    {
        $faker = \Faker\Factory::create();

        $userId = $faker->numberBetween();
        $text =  $faker->sentence();
        $phoneNumber = $faker->phoneNumber();

        $smsSenderMock = $this->createMock(SMSSender::class);
        $smsSenderMock->expects($this->once())
            ->method('send')
            ->with($this->callback(function(SMSMessage $smsMessage) use ($phoneNumber, $text) {
                return $smsMessage->getNumber() === $phoneNumber && $smsMessage->getText() === $text;
            }));

        $testSubject = new SMSSenderWrapper($smsSenderMock);

        $userIdentity = $this->createMock(UserIdentity::class);
        $userIdentity->expects($this->once())
            ->method('getPhone')
            ->willReturn($phoneNumber);

        $notification = new Notification();
        $notification->setUserId($userId);
        $notification->setText($text);
        $notification->setStatus(Notification::STATUS_NEW);

        $testSubject->send($userIdentity, $notification);
    }
}
