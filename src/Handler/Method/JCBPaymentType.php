<?php declare(strict_types=1);

namespace ReepayPayments\Handler\Method;

use ReepayPayments\Handler\ReepayHandler;

class JCBPaymentType extends ReepayHandler
{
    public function paymentMethodCode(): string
    {
        return 'jcb';
    }

    public function paymentMethodName(): string
    {
        return 'JCB';
    }
}