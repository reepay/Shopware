<?php declare(strict_types=1);

namespace ReepayPayments\Handler\Method;

use ReepayPayments\Handler\ReepayHandler;

class VisaPaymentType extends ReepayHandler
{
    public function paymentMethodCode(): string
    {
        return 'visa';
    }

    public function paymentMethodName(): string
    {
        return 'VISA';
    }
}
