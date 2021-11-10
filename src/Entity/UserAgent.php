<?php

namespace App\Entity;

class UserAgent
{
    /**
     * @var string
     */
    private $ip;

    /**
     * @var string
     */
    private $language;

    /**
     * @var string
     */
    private $browser;

    /**
     * @param string $ip
     * @param string $language
     * @param string $browser
     */
    public function __construct(string $ip, string $language, string $browser)
    {
        $this->ip = $ip;
        $this->language = $language;
        $this->browser = $browser;
    }

    /**
     * @return string
     */
    public function getIp() : string
    {
        return $this->ip;
    }

    /**
     * @return string
     */
    public function getLanguage() : string
    {
        return $this->language;
    }

    /**
     * @return string
     */
    public function getBrowser() : string
    {
        return $this->browser;
    }

    public function getWriteInfo() : string
    {
        return json_encode([
            'ip' => $this->ip,
            'language' => $this->language,
            'browser' => $this->browser,
        ], true);
    }
}