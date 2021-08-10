<?php declare(strict_types=1);

namespace ReepayPayments\Handler\Method;

use ReepayPayments\Handler\ReepayHandler;

class ViaBillPaymentType extends ReepayHandler
{
    public function paymentMethodCode(): string
    {
        return 'viabill';
    }

    public function paymentMethodName(): string
    {
        return 'ViaBill';
    }
}