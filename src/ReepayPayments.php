<?php declare(strict_types=1);

namespace ReepayPayments;

use ReepayPayments\Setup\PaymentMethodSetup;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\ActivateContext;
use Shopware\Core\Framework\Plugin\Context\UpdateContext;

if (file_exists(dirname(__DIR__) . '/vendor/autoload.php')) {
    $loader = require_once dirname(__DIR__) . '/vendor/autoload.php';
    if ($loader !== true) {
        spl_autoload_unregister([$loader, 'loadClass']);
        $loader->register(false);
    }
}

class ReepayPayments extends Plugin
{
    public function update(UpdateContext $updateContext): void
    {
        $this->loadPaymentMethods($updateContext->getContext());
    }

    private function loadPaymentMethods(Context $context)
    {
        /** @var PaymentMethodSetup $reepaySetup */
        $reepaySetup = $this->container->get(PaymentMethodSetup::class);
        $reepaySetup->loadPaymentMethods($context);
    }
}
