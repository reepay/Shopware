<?php declare(strict_types=1);

namespace ReepayPayments\Handler\Method;

use ReepayPayments\Handler\ReepayHandler;

class ReepayCheckoutPaymentType extends ReepayHandler
{
    public function paymentMethodCode(): string
    {
        return '';
    }

    public function paymentMethodName(): string
    {
        return 'Reepay Checkout';
    }
}
