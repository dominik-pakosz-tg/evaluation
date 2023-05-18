<?php

namespace App\NotificationPublisher\Infrastructure\Email;

use Aws\Ses\SesClient;

final class AWSSendEmailSender implements EmailSender
{
    private SesClient $client;

    public function __construct()
    {
        $this->client = new SesClient([
            'profile' => 'default',
            'version' => '2010-12-01',
            'region' => 'us-west-2',
        ]);
    }

    public function send(EmailMessage $message): void
    {
        $result = $this->client->sendEmail([
            'Destination' => [
                'ToAddresses' => [
                    $message->getEmail(),
                ],
            ],
            'Message' => [
                'Body' => [
                    'Html' => [
                        'Charset' => 'UTF-8',
                        'Data' => 'This message body contains HTML formatting. It can, for example, contain links like this one: Amazon SES Developer Guide.',
                    ],
                    'Text' => [
                        'Charset' => 'UTF-8',
                        'Data' => $message->getText(),
                    ],
                ],
                'Subject' => [
                    'Charset' => 'UTF-8',
                    'Data' => $message->getSubject(),
                ],
            ],
            'ReplyToAddresses' => [
            ],
            'ReturnPath' => '',
            'ReturnPathArn' => '',
            'Source' => 'sender@example.com',
            'SourceArn' => '',
        ]);
    }
}
