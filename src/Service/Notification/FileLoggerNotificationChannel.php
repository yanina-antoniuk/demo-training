<?php

namespace App\Service\Notification;

use App\Entity\Notification;
use Psr\Log\LoggerInterface;

class FileLoggerNotificationChannel implements NotificationChannelInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function send(Notification $notification): void
    {
        $logEntry = [
            'recipient' => $notification->getRecipient(),
            'message' => $notification->getMessage()
        ];

       $this->logger->info(
           json_encode($logEntry)
       );
    }
}
