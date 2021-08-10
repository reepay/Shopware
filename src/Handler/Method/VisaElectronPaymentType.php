<?php declare(strict_types=1);

namespace ReepayPayments\Handler\Method;

use ReepayPayments\Handler\ReepayHandler;

class VisaElectronPaymentType extends ReepayHandler
{
    public function paymentMethodCode(): string
    {
        return 'visa_elec';
    }

    public function paymentMethodName(): string
    {
        return 'VISA Electron';
    }
}
