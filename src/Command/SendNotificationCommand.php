<?php

namespace App\Command;

use App\Entity\Notification;

class SendNotificationCommand
{
    private $elements;

    public function __construct($elements)
    {
        $this->elements = iterator_to_array($elements[0]);
    }

    public function send(Notification $notification): void
    {
        foreach ($this->elements as $element) {
            if ($element->canSend($notification)) {
                $element->send($notification);
            }
        }
    }
}
