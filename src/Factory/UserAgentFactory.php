<?php

namespace App\Factory;

use App\Entity\UserAgent;

class UserAgentFactory
{

    public function create(array $arguments): UserAgent
    {
        return new UserAgent($arguments['ip'], $arguments['language'], $arguments['browser']);
    }
}