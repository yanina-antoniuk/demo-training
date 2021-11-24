<?php

namespace App\Service\Notification;

use App\Entity\Notification;

interface NotificationChannelInterface
{
    public function canSend(Notification $notification): bool;

    public function send(Notification $notification): void;
}
