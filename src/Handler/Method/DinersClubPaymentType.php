<?php declare(strict_types=1);

namespace ReepayPayments\Handler\Method;

use ReepayPayments\Handler\ReepayHandler;

class DinersClubPaymentType extends ReepayHandler
{
    public function paymentMethodCode(): string
    {
        return 'diners';
    }

    public function paymentMethodName(): string
    {
        return 'Diners Club';
    }
}