<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Factory;

use App\Entity\UserAgent;

class UserAgentFactory
{
    public function create(array $arguments): UserAgent
    {
        return new UserAgent($arguments['ip'], $arguments['language'], $arguments['browser']);
    }
}
