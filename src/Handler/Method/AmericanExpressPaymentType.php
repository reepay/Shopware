<?php declare(strict_types=1);

namespace ReepayPayments\Handler\Method;

use ReepayPayments\Handler\ReepayHandler;

class AmericanExpressPaymentType extends ReepayHandler
{
    public function paymentMethodCode(): string
    {
        return 'amex';
    }

    public function paymentMethodName(): string
    {
        return 'American Express';
    }
}