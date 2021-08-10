<?php declare(strict_types=1);

namespace ReepayPayments\Command;

use ReepayPayments\Setup\PaymentMethodSetup;
use Shopware\Core\Framework\Context;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SetupPaymentMethodCommand extends Command
{
    protected static $defaultName = 'reepay:setup:payment-methods';

    /**
     * @var PaymentMethodSetup
     */
    private $setup;

    public function __construct(
        PaymentMethodSetup $setup
    ) {
        parent::__construct();
        $this->setup = $setup;
    }

    public function run(InputInterface $input, OutputInterface $output)
    {
        $this->setup->loadPaymentMethods(Context::createDefaultContext());

        return 0;
    }
}
