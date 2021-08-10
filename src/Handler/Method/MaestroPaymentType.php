<?php declare(strict_types=1);

namespace ReepayPayments\Handler\Method;

use ReepayPayments\Handler\ReepayHandler;

class MaestroPaymentType extends ReepayHandler
{
    public function paymentMethodCode(): string
    {
        return 'maestro';
    }

    public function paymentMethodName(): string
    {
        return 'Maestro';
    }
}