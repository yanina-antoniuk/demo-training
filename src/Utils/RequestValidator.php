<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Utils;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;

class RequestValidator
{
    public function validateContentType(Request $request): void
    {
        if ('application/json' === !$request->server->get('CONTENT_TYPE')) {
            throw new UnsupportedMediaTypeHttpException();
        }
    }
}
