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

class TelegramNotificationChannel implements NotificationChannelInterface
{
    private string $telegramApiKey;

    private string $telegramSendMessageUri;

    private string $telegramChatIdentifier;

    public function __construct(
        string $telegramApiKey,
        string $telegramSendMessageUri,
        string $telegramChatIdentifier
    ) {
        $this->telegramApiKey = $telegramApiKey;
        $this->telegramSendMessageUri = $telegramSendMessageUri;
        $this->telegramChatIdentifier = $telegramChatIdentifier;
    }

    /**
     * @throws \Exception
     */
    public function send(Notification $notification): void
    {
        $params = [
            'chat_id' => $this->telegramChatIdentifier,
            'username' => $notification->getRecipient(),
            'text' => $notification->getMessage(),
        ];

        $ch = curl_init(sprintf($this->telegramSendMessageUri, $this->telegramApiKey));
        curl_setopt($ch, \CURLOPT_HEADER, false);
        curl_setopt($ch, \CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, \CURLOPT_POST, 1);
        curl_setopt($ch, \CURLOPT_POSTFIELDS, ($params));
        curl_setopt($ch, \CURLOPT_SSL_VERIFYPEER, false);
        curl_close($ch);
    }
}
