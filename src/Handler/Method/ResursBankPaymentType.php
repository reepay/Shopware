<?php declare(strict_types=1);

namespace ReepayPayments\Handler\Method;

use ReepayPayments\Handler\ReepayHandler;

class ResursBankPaymentType extends ReepayHandler
{
    public function paymentMethodCode(): string
    {
        return 'resurs';
    }

    public function paymentMethodName(): string
    {
        return 'Resurs Bank';
    }
}