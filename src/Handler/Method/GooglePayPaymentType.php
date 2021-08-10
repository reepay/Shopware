<?php declare(strict_types=1);

namespace ReepayPayments\Handler\Method;

use ReepayPayments\Handler\ReepayHandler;

class GooglePayPaymentType extends ReepayHandler
{
    public function paymentMethodCode(): string
    {
        return 'googlepay';
    }

    public function paymentMethodName(): string
    {
        return 'Google Pay';
    }
}