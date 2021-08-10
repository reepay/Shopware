<?php declare(strict_types=1);

namespace ReepayPayments\Subscriber;

use Reepay\Model\Invoice;
use ReepayPayments\Service\Api\InvoiceApi;
use ReepayPayments\Service\ConfigurationService;
use Shopware\Core\Checkout\Order\Aggregate\OrderTransaction\OrderTransactionEntity;
use Shopware\Core\Checkout\Order\OrderEntity;
use Shopware\Core\Checkout\Order\OrderStates;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\System\StateMachine\Event\StateMachineStateChangeEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class OrderStateSubscriber implements EventSubscriberInterface
{
    /**
     * @var ConfigurationService
     */
    private $configuration;
    /**
     * @var InvoiceApi
     */
    private $invoiceApi;
    /**
     * @var EntityRepositoryInterface
     */
    private $orderRepository;

    public function __construct(
        ConfigurationService $configuration,
        InvoiceApi $invoiceApi,
        EntityRepositoryInterface $orderRepository
    ) {
        $this->configuration = $configuration;
        $this->invoiceApi = $invoiceApi;
        $this->orderRepository = $orderRepository;
    }

    public static function getSubscribedEvents()
    {
        return [
            'state_machine.order.state_changed' => 'onOrderStateChange',
        ];
    }

    public function onOrderStateChange(StateMachineStateChangeEvent $event)
    {
        if (!$this->configuration->isOrderStateSettleInvoiceOnComplete()) {
            return;
        }

        if ($event->getNextState()->getTechnicalName() === OrderStates::STATE_COMPLETED) {
            $criteria = new Criteria([$event->getTransition()->getEntityId()]);
            $criteria->addAssociation('transactions');

            /** @var OrderEntity $order */
            $order = $this->orderRepository->search($criteria, $event->getContext())->first();
            if (!$order || !$order->getTransactions()) {
                return;
            }

            /** @var OrderTransactionEntity $transaction */
            $transaction = $order->getTransactions()->last();

            $invoice = $this->invoiceApi->getInvoice($transaction->getId());

            if ($invoice && $invoice->getState() !== Invoice::STATE_SETTLED) {
                $this->invoiceApi->settleInvoice($transaction->getId());
            }
        }
    }
}
