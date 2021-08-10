<?php declare(strict_types=1);

namespace ReepayPayments\Handler\Method;

use ReepayPayments\Handler\ReepayHandler;

class MasterCardPaymentType extends ReepayHandler
{
    public function paymentMethodCode(): string
    {
        return 'mc';
    }

    public function paymentMethodName(): string
    {
        return 'MasterCard';
    }
}
