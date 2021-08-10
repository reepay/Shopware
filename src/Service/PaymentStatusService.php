<?php declare(strict_types=1);

namespace ReepayPayments\Service;

use Reepay\Model\Invoice;
use ReepayPayments\Service\Api\InvoiceApi;
use Shopware\Core\Checkout\Order\Aggregate\OrderTransaction\OrderTransactionEntity;
use Shopware\Core\Checkout\Order\Aggregate\OrderTransaction\OrderTransactionStateHandler;
use Shopware\Core\Checkout\Order\Aggregate\OrderTransaction\OrderTransactionStates;
use Shopware\Core\Checkout\Order\OrderStates;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\System\StateMachine\Aggregation\StateMachineTransition\StateMachineTransitionActions as OrderStateActions;
use Shopware\Core\System\StateMachine\StateMachineRegistry;
use Shopware\Core\System\StateMachine\Transition;

class PaymentStatusService
{
    /**
     * @var InvoiceApi
     */
    private $invoiceApi;
    /**
     * @var EntityRepositoryInterface
     */
    private $orderTransactionRepository;
    /**
     * @var OrderTransactionStateHandler
     */
    private $transactionStateHandler;
    /**
     * @var StateMachineRegistry
     */
    private $stateMachineRegistry;
    /**
     * @var ConfigurationService
     */
    private $configuration;

    public function __construct(
        InvoiceApi $invoiceApi,
        EntityRepositoryInterface $orderTransactionRepository,
        OrderTransactionStateHandler $transactionStateHandler,
        StateMachineRegistry $stateMachineRegistry,
        ConfigurationService $configuration
    ) {
        $this->invoiceApi = $invoiceApi;
        $this->orderTransactionRepository = $orderTransactionRepository;
        $this->transactionStateHandler = $transactionStateHandler;
        $this->stateMachineRegistry = $stateMachineRegistry;
        $this->configuration = $configuration;
    }

    public function updatePaymentForInvoice(string $invoiceId, Context $context): void
    {
        $invoice = $this->invoiceApi->getInvoice($invoiceId);

        $shopwareTransactionId = $invoice->getHandle();

        $criteria = new Criteria([$shopwareTransactionId]);
        $criteria->addAssociation('order');

        /** @var OrderTransactionEntity $orderTransaction */
        $orderTransaction = $this->orderTransactionRepository->search($criteria, $context)->first();
        $order = $orderTransaction->getOrder();

        if ($invoice->getState() === Invoice::STATE_AUTHORIZED &&
            $orderTransaction->getStateMachineState()->getTechnicalName() !== OrderTransactionStates::STATE_PAID) {
            $this->transactionStateHandler->paid($orderTransaction->getId(), $context);
        }
        if ($invoice->getState() === Invoice::STATE_SETTLED &&
            $orderTransaction->getStateMachineState()->getTechnicalName() !== OrderTransactionStates::STATE_IN_PROGRESS) {
            $this->transactionStateHandler->process($orderTransaction->getId(), $context);
        }
        if ($invoice->getState() === Invoice::STATE_FAILED &&
            $orderTransaction->getStateMachineState()->getTechnicalName() !== OrderTransactionStates::STATE_FAILED) {
            $this->transactionStateHandler->fail($orderTransaction->getId(), $context);
        }
        if ($invoice->getState() === Invoice::STATE_CANCELLED &&
            $orderTransaction->getStateMachineState()->getTechnicalName() !== OrderTransactionStates::STATE_CANCELLED) {
            $this->transactionStateHandler->cancel($orderTransaction->getId(), $context);
        }

        if (!$order) {
            return;
        }

        switch ($invoice->getState()) {
            case 'created':
                $newState = $this->configuration->getOrderStateCreated();
                break;
            case Invoice::STATE_PENDING:
                $newState = $this->configuration->getOrderStatePending();
                break;
            case Invoice::STATE_DUNNING:
                $newState = $this->configuration->getOrderStateDunning();
                break;
            case Invoice::STATE_SETTLED:
                $newState = $this->configuration->getOrderStateSettled();
                break;
            case Invoice::STATE_CANCELLED:
                $newState = $this->configuration->getOrderStateCancelled();
                break;
            case Invoice::STATE_AUTHORIZED:
                $newState = $this->configuration->getOrderStateAuthorized();
                break;
            case Invoice::STATE_FAILED:
                $newState = $this->configuration->getOrderStateFailed();
                break;
        }

        if (!isset($newState) ||
            empty($newState) ||
            $newState === ConfigurationService::CONFIG_ORDER_STATE_NO_CHANGE_PLACEHOLDER) {
            return;
        }

        $this->transitionOrder(
            $order->getId(),
            $newState,
            $context
        );
    }

    public function transitionOrder(string $orderId, string $newState, Context $context): void
    {
        if (!in_array($newState, [
            OrderStates::STATE_OPEN,
            OrderStates::STATE_IN_PROGRESS,
            OrderStates::STATE_CANCELLED,
            OrderStates::STATE_COMPLETED,
        ], true)) {
            return;
        }

        switch ($newState) {
            case OrderStates::STATE_OPEN:
                $transition = OrderStateActions::ACTION_REOPEN;
                break;
            case OrderStates::STATE_IN_PROGRESS:
                $transition = OrderStateActions::ACTION_PROCESS;
                break;
            case OrderStates::STATE_CANCELLED:
                $transition = OrderStateActions::ACTION_CANCEL;
                break;
            case OrderStates::STATE_COMPLETED:
                $transition = OrderStateActions::ACTION_COMPLETE;
                break;
        }

        if (!isset($transition)) {
            return;
        }

        try {
            $this->stateMachineRegistry->transition(
                new Transition(
                    'order',
                    $orderId,
                    $transition,
                    'stateId'
                ),
                $context
            );
        } catch (\Exception $e) {
            //
        }
    }
}
