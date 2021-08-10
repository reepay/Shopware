<?php declare(strict_types=1);

namespace ReepayPayments\Handler\Method;

use ReepayPayments\Handler\ReepayHandler;

class ForbrugsforeningenPaymentType extends ReepayHandler
{
    public function paymentMethodCode(): string
    {
        return 'ffk';
    }

    public function paymentMethodName(): string
    {
        return 'Forbrugsforeningen';
    }
}