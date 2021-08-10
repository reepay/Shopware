<?php declare(strict_types=1);

namespace ReepayPayments\Handler\Method;

use ReepayPayments\Handler\ReepayHandler;

class PayPalPaymentType extends ReepayHandler
{
    public function paymentMethodCode(): string
    {
        return 'paypal';
    }

    public function paymentMethodName(): string
    {
        return 'PayPal';
    }
}