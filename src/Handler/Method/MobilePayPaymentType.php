<?php declare(strict_types=1);

namespace ReepayPayments\Handler\Method;

use ReepayPayments\Handler\ReepayHandler;

class MobilePayPaymentType extends ReepayHandler
{
    public function paymentMethodCode(): string
    {
        return 'mobilepay';
    }

    public function paymentMethodName(): string
    {
        return 'MobilePay';
    }
}