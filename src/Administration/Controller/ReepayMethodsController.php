<?php


namespace ReepayPayments\Administration\Controller;

use ReepayPayments\Handler\ReepayHandler;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @RouteScope(scopes={"api"})
 */
class ReepayMethodsController extends AbstractController
{
    /**
     * @var iterable|ReepayHandler[]|\Traversable
     */
    private $paymentHandlers;

    public function __construct(
        iterable $paymentHandlers
    ) {
        $this->paymentHandlers = $paymentHandlers;
    }

    /**
     * @Route("/api/v{version}/reepay-payments/method-options", name="api.action.reepay-payments.method-options", methods={"GET"})
     */
    public function paymentMethodOptions(Request $request, Context $context): JsonResponse
    {
        return new JsonResponse(array_values(array_map(function (ReepayHandler $handler) {
            return [
                'label' => $handler->paymentMethodName(),
                'value' => $handler->paymentMethodCode()
            ];
        }, iterator_to_array($this->paymentHandlers))));
    }
}
