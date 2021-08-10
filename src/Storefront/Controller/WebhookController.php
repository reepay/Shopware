<?php

namespace ReepayPayments\Storefront\Controller;

use ReepayPayments\Message\WebhookMessage;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * https://reference.reepay.com/api/#webhooks
 */
class WebhookController extends StorefrontController
{
    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    public function __construct(
        MessageBusInterface $messageBus
    ) {
        $this->messageBus = $messageBus;
    }

    /**
     * @RouteScope(scopes={"storefront"})
     * @Route("/reepay/webhook", defaults={"csrf_protected"=false}, name="frontend.reepay.webhook", options={"seo"="false"}, methods={"GET", "POST"})
     */
    public function webhookAction(Request $request, SalesChannelContext $context): Response
    {
        $this->messageBus->dispatch(new WebhookMessage($request->request->all(), $context->getContext()));
        return new Response();
    }
}
