<?php

declare(strict_types=1);

namespace ReepayPayments\Command;

use ReepayPayments\Service\Api\AccountApi;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateWebhooksCommand extends Command
{
    protected static $defaultName = 'reepay:update-webhook-settings';
    /**
     * @var AccountApi
     */
    private $accountApi;

    public function __construct(
        AccountApi $accountApi
    ) {
        parent::__construct();
        $this->accountApi = $accountApi;
    }

    public function run(InputInterface $input, OutputInterface $output)
    {
        $this->accountApi->updateAccountWebhooks();
        return 0;
    }
}
