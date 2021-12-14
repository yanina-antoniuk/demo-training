<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;

final class ApiContentTypeListener
{
    public function onKernelRequest(RequestEvent $event)
    {
        $uri = $event->getRequest()->server->get('REQUEST_URI');
        preg_match('/\b(api)\b/', $uri, $matches);

        if (
            !empty($matches)
            && 'application/json' !== $event->getRequest()->server->get('HTTP_CONTENT_TYPE')
            && !mb_strpos($uri, 'config')
        ) {
            throw new UnsupportedMediaTypeHttpException();
        }
    }
}
