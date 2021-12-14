<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
            'message' => $notification->getMessage(),
        ];

        $this->logger->info(
           json_encode($logEntry)
       );
    }
}
