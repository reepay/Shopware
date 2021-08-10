<?php declare(strict_types=1);

namespace ReepayPayments\Handler\Method;

use ReepayPayments\Handler\ReepayHandler;

class KlarnaPayLaterPaymentType extends ReepayHandler
{
    public function paymentMethodCode(): string
    {
        return 'klarna_pay_later';
    }

    public function paymentMethodName(): string
    {
        return 'Klarna Pay Later';
    }
}