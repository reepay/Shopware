<?php declare(strict_types=1);

namespace ReepayPayments\Handler\Method;

use ReepayPayments\Handler\ReepayHandler;

class VippsPaymentType extends ReepayHandler
{
    public function paymentMethodCode(): string
    {
        return 'vipps';
    }

    public function paymentMethodName(): string
    {
        return 'Vipps';
    }
}