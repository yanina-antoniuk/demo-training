<?php

namespace App\Controller;

use App\Factory\UserAgentFactory;
use App\Service\CsvParser;
use App\Service\ProductHandler;
use App\Service\UserAgentInfoHandler;
use App\Utils\RequestValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductApiController extends AbstractController
{
    /**
     * @Route("/api", name="api", methods={"GET"}, requirements={"info":"info"})
     *
     * @param ProductHandler $productHandler
     * @param CsvParser $csvParser
     * @param Request $request
     * @param RequestValidator $requestValidator
     *
     * @return Response
     */
    public function index(
        ProductHandler $productHandler,
        CsvParser $csvParser,
        Request $request,
        RequestValidator $requestValidator
    ): Response {
        $requestValidator->validateContentType($request);

        $parsedProducts = $csvParser->getParsedProducts();

        $absolutePath = rtrim($request->server->get('SYMFONY_DEFAULT_ROUTE_URL'), '/')
            . $request->server->get('REQUEST_URI');

        return new JsonResponse(
            $productHandler->getProductsLinksList($parsedProducts, $absolutePath),
            Response::HTTP_OK,
            ['Content-Type: application/json']
        );
    }

    /**
     * @Route("/api/info", name="api_info", requirements={"info":"info"}, methods={"GET"})
     *
     * @param Request $request
     * @param UserAgentFactory $factory
     * @param UserAgentInfoHandler $handler
     * @param RequestValidator $requestValidator
     *
     * @return Response
     */
    public function info(
        Request $request,
        UserAgentFactory $factory,
        UserAgentInfoHandler $handler,
        RequestValidator $requestValidator
    ): Response {
        $requestValidator->validateContentType($request);

        $arguments = [
            'ip' => $request->getClientIp(),
            'language' => $request->getPreferredLanguage(),
            'browser' => $request->server->get('HTTP_SEC_CH_UA'),
        ];

       $userAgent = $factory->create($arguments);

       $handler->writeUserAgentInfo($userAgent);

        return new JsonResponse(
            'This is info',
            Response::HTTP_OK,
            ['Content-Type: application/json']
        );
    }

    /**
     * @Route("/api/{slug}", name="api_product_show", defaults={"_format": "json"}, methods={"GET"})
     *
     * @param string $slug
     * @param ProductHandler $productHandler
     * @param CsvParser $csvParser
     * @param Request $request
     * @param RequestValidator $requestValidator
     *
     * @return Response
     */
    public function show(
        string $slug,
        ProductHandler $productHandler,
        CsvParser $csvParser,
        Request $request,
        RequestValidator $requestValidator
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
