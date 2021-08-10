<?php declare(strict_types=1);

namespace ReepayPayments\Administration\Controller;

use Livereach\ContentStream\Service\LivereachApiService;
use ReepayPayments\Service\Api\AccountApi;
use ReepayPayments\Service\Api\TestApi;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @RouteScope(scopes={"api"})
 */
class ApiKeyTestController extends AbstractController
{
    /**
     * @var TestApi
     */
    private $testApi;

    public function __construct(
        TestApi $testApi
    ) {
        $this->testApi = $testApi;
    }

    /**
     * @Route("/api/v{version}/reepay-payments/test-api", name="api.action.reepay-payments.test-api", methods={"POST"})
     */
    public function testApiKey(Request $request, Context $context): JsonResponse
    {
        return new JsonResponse([
            'apiKeyCorrect' => $this->testApi->testApiKey($request->get('key'))
        ]);
    }
}
