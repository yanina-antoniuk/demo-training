<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;

final class ApiContentTypeListener
{
    public function onKernelRequest(RequestEvent $event)
    {
        preg_match('/\b(api)\b/', $event->getRequest()->server->get('REQUEST_URI'), $matches);

        if (
            !empty($matches)
            && $event->getRequest()->server->get('HTTP_CONTENT_TYPE') !== 'application/json'
            && $event->getRequest()->server->get('REQUEST_METHOD') == 'GET'
        ) {
            throw new UnsupportedMediaTypeHttpException();
        }
    }
}