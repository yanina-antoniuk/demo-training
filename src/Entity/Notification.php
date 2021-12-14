<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use Symfony\Component\Notifier\Notification\Notification as SymfonyNotification;
use Symfony\Component\Validator\Constraints as Assert;

class Notification extends SymfonyNotification
{
    /**
     * @Assert\Type(type={"alpha", "digit"})
     * @Assert\NotBlank
     */
    private string $recipient;

    /**
     * @Assert\Type(type={"alpha", "digit"})
     * @Assert\NotBlank
     */
    private string $message;

    /**
     * @Assert\Type(type={"alpha", "digit"})
     * @Assert\NotBlank
     */
    private string $channel;

    public function __construct(
        string $recipient,
        string $message,
        string $channel
    ) {
        parent::__construct();

        $this->recipient = $recipient;
        $this->message = $message;
        $this->channel = $channel;
    }

    public function getRecipient(): string
    {
        return $this->recipient;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getChannel(): string
    {
        return $this->channel;
    }
}
