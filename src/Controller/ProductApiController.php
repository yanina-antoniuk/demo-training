<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Factory\UserAgentFactory;
use App\Service\CsvParser;
use App\Service\ProductInfoService;
use App\Service\UserAgentInfoVisitLogger;
use App\Utils\RequestValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductApiController extends AbstractController
{
    /**
     * @Route("/api", name="api", methods={"GET"})
     */
    public function index(
        ProductInfoService $productHandler,
        CsvParser          $csvParser,
        Request            $request,
        RequestValidator   $requestValidator
    ): Response {
        $requestValidator->validateContentType($request);

        $parsedProducts = $csvParser->getParsedProducts();

        $absolutePath = rtrim($request->server->get('SYMFONY_DEFAULT_ROUTE_URL'), '/')
            .$request->server->get('REQUEST_URI');

        return new JsonResponse(
            $productHandler->getProductsLinksList($parsedProducts, $absolutePath),
            Response::HTTP_OK,
            ['Content-Type: application/json']
        );
    }

    /**
     * @Route("/api/info", name="api_info", methods={"GET"})
     */
    public function info(
        Request $request,
        UserAgentFactory $factory,
        UserAgentInfoVisitLogger $handler,
        RequestValidator $requestValidator
    ): Response {
        $requestValidator->validateContentType($request);

        $userAgent = $factory->create(
            $request->getClientIp(),
            $request->getPreferredLanguage(),
            $request->server->get('HTTP_SEC_CH_UA')
        );

        $handler->writeUserAgentInfo($userAgent);

        return new JsonResponse(
            'This is info',
            Response::HTTP_OK,
            ['Content-Type: application/json']
        );
    }

    /**
     * @Route("/api/{slug}", name="api_product_show", defaults={"_format": "json"}, methods={"GET"})
     */
    public function show(
        string             $slug,
        ProductInfoService $productHandler,
        CsvParser          $csvParser,
        Request            $request,
        RequestValidator   $requestValidator
    ): Response {
        $requestValidator->validateContentType($request);

        $parsedProducts = $csvParser->getParsedProducts();

        return new JsonResponse(
            $productHandler->getProductInfo($slug, $parsedProducts),
            Response::HTTP_OK,
            ['Content-Type: application/json']
        );
    }
}
