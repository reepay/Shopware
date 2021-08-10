<?php declare(strict_types=1);

namespace ReepayPayments\Handler\Method;

use ReepayPayments\Handler\ReepayHandler;

class ChinaUnionPayPaymentType extends ReepayHandler
{
    public function paymentMethodCode(): string
    {
        return 'china_union_pay';
    }

    public function paymentMethodName(): string
    {
        return 'China Union Pay';
    }
}