<?php

namespace App\Utils;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;

class RequestValidator
{
    /**
     * @param Request $request
     */
    public function validateContentType(Request $request) : void
    {
        if (!$request->server->get('CONTENT_TYPE') == 'application/json') {
            throw new UnsupportedMediaTypeHttpException();
        }
    }
}
