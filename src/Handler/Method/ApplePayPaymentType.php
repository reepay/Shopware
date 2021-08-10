<?php declare(strict_types=1);

namespace ReepayPayments\Handler\Method;

use ReepayPayments\Handler\ReepayHandler;

class ApplePayPaymentType extends ReepayHandler
{
    public function paymentMethodCode(): string
    {
        return 'applepay';
    }

    public function paymentMethodName(): string
    {
        return 'Apple Pay';
    }
}