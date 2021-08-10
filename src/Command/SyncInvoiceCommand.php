<?php declare(strict_types=1);

namespace ReepayPayments\Command;

use ReepayPayments\Service\PaymentStatusService;
use Shopware\Core\Framework\Context;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SyncInvoiceCommand extends Command
{
    protected static $defaultName = 'reepay:sync:invoice';

    /**
     * @var PaymentStatusService
     */
    private $paymentStatusService;

    public function __construct(
        PaymentStatusService $paymentStatusService
    ) {
        parent::__construct();
        $this->paymentStatusService = $paymentStatusService;
    }

    protected function configure()
    {
        $this->addArgument('invoice');
    }

    public function run(InputInterface $input, OutputInterface $output)
    {
        $this->paymentStatusService->updatePaymentForInvoice(
            $input->getArgument('invoice'),
            Context::createDefaultContext()
        );

        return 0;
    }
}
