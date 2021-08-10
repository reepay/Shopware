<?php declare(strict_types=1);

namespace ReepayPayments\Message;

use ReepayPayments\Service\PaymentStatusService;
use Shopware\Core\Framework\MessageQueue\Handler\AbstractMessageHandler;

class WebhookMessageHandler extends AbstractMessageHandler
{
    /**
     * @var PaymentStatusService
     */
    private $paymentStatusService;

    public function __construct(
        PaymentStatusService $paymentStatusService
    ) {
        $this->paymentStatusService = $paymentStatusService;
    }

    /**
     * @param WebhookMessage $message
     */
    public function handle($message): void
    {
        ;
        if (!($raw = $message->getData()['content']) || empty($raw)) {
            return;
        }
        $json = json_decode($raw);
        if (!$invoice = $json['invoice']) {
            return;
        }

        $this->paymentStatusService->updatePaymentForInvoice(
            $invoice,
            $message->getContext()
        );
    }

    public static function getHandledMessages(): iterable
    {
        return [
            WebhookMessage::class
        ];
    }
}
