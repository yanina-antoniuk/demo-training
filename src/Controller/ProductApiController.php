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

use App\Command\SendNotificationCommand;
use App\Factory\NotificationFactory;
use App\Factory\UserAgentFactory;
use App\Repository\ProductImageRepository;
use App\Service\CsvParser;
use App\Service\Notification\EmailNotificationChannel;
use App\Service\Notification\FileLoggerNotificationChannel;
use App\Service\Notification\TelegramNotificationChannel;
use App\Service\ProductInfoService;
use App\Service\SimplePaginator;
use App\Service\UserAgentInfoVisitLogger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class ProductApiController extends AbstractController
{
    /**
     * @Route("/api", name="api", methods={"GET"})
     */
    public function index(
        ProductInfoService $productHandler,
        CsvParser $csvParser,
        Request $request
    ): Response {

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
        UserAgentInfoVisitLogger $handler
    ): Response {
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
        string $slug,
        ProductInfoService $productHandler,
        CsvParser $csvParser,
        TranslatorInterface $translator
    ): Response {
        $parsedProducts = $csvParser->getParsedProducts();
        $product = $productHandler->getProductInfo($slug, $parsedProducts);
        $productTranslated = [];

        foreach ($product as $key => $value) {
            $translatedKey = $translator->trans($key);
            $productTranslated[$translatedKey] = $value;
        }

        return new JsonResponse(
            json_encode($productTranslated, 256),
            Response::HTTP_OK,
            ['Content-Type: application/json'],
            true
        );
    }

    /**
     * @Route("/api/notify", name="api_notify", defaults={"_format": "json"}, methods={"POST"})
     */
    public function notify(
        Request $request,
        NotificationFactory $notificationFactory,
        SendNotificationCommand $notificationCommand
    ): Response {
        try {
            $data = $request->toArray();

            $notification = $notificationFactory->create(
                $data['recipient'],
                $data['message'],
                $data['channel']
            );

            $notificationCommand->send($notification);

            $result = true;
        } catch (\Throwable $exception) {
            $result = false;
        }

        return new JsonResponse(
            $result ? 'Sent!' : 'Failed to send!',
            $result ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST,
            ['Content-Type: application/json'],
            true
        );
    }

    /**
     * @Route("/api/product/images", name="api_products", defaults={"_format": "json"}, methods={"GET"})
     */
    public function getProduct(
        Request $request,
        ProductImageRepository $imageRepository,
        SimplePaginator $paginator
    ): Response {
        $paginationData = $request->query->all();
        $result = $imageRepository->getImagesWithProductPaginated();

        return new JsonResponse(
            $paginator->paginate(
                $result,
                $paginationData['limit'],
                $paginationData['page']
            ),
            Response::HTTP_OK,
            ['Content-Type: application/json'],
            false
        );
    }
}
