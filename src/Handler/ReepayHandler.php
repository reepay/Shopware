<?php declare(strict_types=1);

namespace ReepayPayments\Handler;

use ReepayPayments\Service\Api\InvoiceApi;
use ReepayPayments\Service\Api\SessionApi;
use ReepayPayments\Service\PaymentStatusService;
use Shopware\Core\Checkout\Payment\Cart\AsyncPaymentTransactionStruct;
use Shopware\Core\Checkout\Payment\Cart\PaymentHandler\AsynchronousPaymentHandlerInterface;
use Shopware\Core\Checkout\Payment\Exception\AsyncPaymentProcessException;
use Shopware\Core\Checkout\Payment\Exception\CustomerCanceledAsyncPaymentException;
use Shopware\Core\Framework\Validation\DataBag\RequestDataBag;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

abstract class ReepayHandler implements AsynchronousPaymentHandlerInterface
{
    /**
     * @var SessionApi
     */
    private $sessionApi;

    /**
     * @var InvoiceApi
     */
    private $invoiceApi;

    /**
     * @var PaymentStatusService
     */
    private $paymentStatusService;

    abstract public function paymentMethodCode(): string;
    abstract public function paymentMethodName(): string;

    public function __construct(
        SessionApi $sessionApi,
        InvoiceApi $invoiceApi,
        PaymentStatusService $paymentStatusService
    ) {
        $this->sessionApi = $sessionApi;
        $this->invoiceApi = $invoiceApi;
        $this->paymentStatusService = $paymentStatusService;
    }

    public function pay(AsyncPaymentTransactionStruct $transaction, RequestDataBag $dataBag, SalesChannelContext $salesChannelContext): RedirectResponse
    {
        try {
            $session = $this->sessionApi->createSession(
                $transaction->getOrder(),
                $transaction->getOrderTransaction(),
                $transaction->getReturnUrl(),
                $this->paymentMethodCode(),
                $salesChannelContext->getContext()
            );

            return new RedirectResponse($session->getUrl());
        } catch (\Exception $exception) {
            throw new AsyncPaymentProcessException(
                $transaction->getOrderTransaction()->getId(),
                $exception->getMessage()
            );
        }
    }

    public function finalize(AsyncPaymentTransactionStruct $transaction, Request $request, SalesChannelContext $salesChannelContext): void
    {
        if ($request->query->has('cancel')) {
            throw new CustomerCanceledAsyncPaymentException($transaction->getOrderTransaction()->getId());
        }

        $invoiceId = $request->query->get('invoice');
        if (!$invoiceId) {
            return;
        }

        $this->paymentStatusService->updatePaymentForInvoice($invoiceId, $salesChannelContext->getContext());
    }
}
