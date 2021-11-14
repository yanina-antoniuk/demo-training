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
    /**
     * @param string $ip
     * @param string $language
     * @param string $browser
     * @return UserAgent
     */
    public function create(string $ip, string  $language, string $browser): UserAgent
    {
        return new UserAgent($ip, $language, $browser);
    }
}
