<?php

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
            && $event->getRequest()->server->get('HTTP_CONTENT_TYPE') !== 'application/json'
            && !strpos($uri, 'config')
        ) {
            throw new UnsupportedMediaTypeHttpException();
        }
    }
}