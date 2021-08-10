<?php declare(strict_types=1);

namespace ReepayPayments\Handler\Method;

use ReepayPayments\Handler\ReepayHandler;

class KlarnaSliceItPaymentType extends ReepayHandler
{
    public function paymentMethodCode(): string
    {
        return 'klarna_slice_it';
    }

    public function paymentMethodName(): string
    {
        return 'Klarna Slice It';
    }
}