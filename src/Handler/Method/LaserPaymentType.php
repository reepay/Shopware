<?php declare(strict_types=1);

namespace ReepayPayments\Handler\Method;

use ReepayPayments\Handler\ReepayHandler;

class LaserPaymentType extends ReepayHandler
{
    public function paymentMethodCode(): string
    {
        return 'laser';
    }

    public function paymentMethodName(): string
    {
        return 'Laser';
    }
}