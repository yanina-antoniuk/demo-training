<?php

namespace App\Command;

use App\Entity\Notification;

class SendNotificationCommand
{
    private $serviceLocator;

    public function __construct($serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function send(Notification $notification): void
    {
        $service = $this->serviceLocator->get($notification->getChannel());
        $service->send($notification);
    }
}
