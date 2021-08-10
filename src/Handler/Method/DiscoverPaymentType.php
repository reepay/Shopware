<?php declare(strict_types=1);

namespace ReepayPayments\Handler\Method;

use ReepayPayments\Handler\ReepayHandler;

class DiscoverPaymentType extends ReepayHandler
{
    public function paymentMethodCode(): string
    {
        return 'discover';
    }

    public function paymentMethodName(): string
    {
        return 'Discover';
    }
}