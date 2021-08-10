<?php declare(strict_types=1);

namespace ReepayPayments\Handler\Method;

use ReepayPayments\Handler\ReepayHandler;

class DankortPaymentType extends ReepayHandler
{
    public function paymentMethodCode(): string
    {
        return 'dankort';
    }

    public function paymentMethodName(): string
    {
        return 'Dankort';
    }
}