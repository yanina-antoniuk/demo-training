<?php

namespace App\Service\Notification;

use App\Entity\Notification;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

class EmailNotificationChannel implements NotificationChannelInterface
{
    private const CHANNEL_NAME = 'email';

    private Mailer $mailer;

    private Email $email;

    public function __construct(Mailer $mailer, Email $email)
    {
        $this->mailer = $mailer;
        $this->email = $email;
    }

    public function canSend(Notification $notification): bool
    {
        return $notification->getChannel() === self::CHANNEL_NAME;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function send(Notification $notification): void
    {
        $email = ($this->email)
            ->to($notification->getRecipient())
            ->subject('test')
            ->text($notification->getMessage());

        $this->mailer->send($email);
    }
}
