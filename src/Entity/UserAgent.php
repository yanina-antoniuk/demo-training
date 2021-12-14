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

class UserAgent
{
    private string $ip;

    private string $language;

    private string $browser;

    public function __construct(string $ip, string $language, string $browser)
    {
        $this->ip = $ip;
        $this->language = $language;
        $this->browser = $browser;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function getBrowser(): string
    {
        return $this->browser;
    }

    public function getWriteInfo(): string
    {
        return json_encode([
            'ip' => $this->ip,
            'language' => $this->language,
            'browser' => $this->browser,
        ], true);
    }
}
