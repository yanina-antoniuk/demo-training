<?php

namespace App\Service\Notification;

use App\Entity\Notification;

class TelegramNotificationChannel implements NotificationChannelInterface
{
    private const CHANNEL_NAME = 'telegram';

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

    public function canSend(Notification $notification): bool
    {
        return $notification->getChannel() === self::CHANNEL_NAME;
    }

    /**
     * @throws \Exception
     */
    public function send(Notification $notification): void
    {
        $params=[
            'chat_id'=> $this->telegramChatIdentifier,
            'username' => $notification->getRecipient(),
            'text'=> $notification->getMessage(),
        ];

        $ch = curl_init(sprintf($this->telegramSendMessageUri, $this->telegramApiKey));
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_close($ch);
    }
}
