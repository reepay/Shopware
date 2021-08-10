<?php declare(strict_types=1);

namespace ReepayPayments\Handler\Method;

use ReepayPayments\Handler\ReepayHandler;

class CreditCardPaymentType extends ReepayHandler
{
    public function paymentMethodCode(): string
    {
        return 'card';
    }

    public function paymentMethodName(): string
    {
        return 'Credit Card';
    }
}