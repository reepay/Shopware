<?php declare(strict_types=1);

namespace ReepayPayments\Handler\Method;

use ReepayPayments\Handler\ReepayHandler;

class SwishPaymentType extends ReepayHandler
{
    public function paymentMethodCode(): string
    {
        return 'swish';
    }

    public function paymentMethodName(): string
    {
        return 'Swish';
    }
}