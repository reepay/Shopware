<?php declare(strict_types=1);

namespace ReepayPayments\Command;

use ReepayPayments\Handler\ReepayHandler;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DevelopmentAddPaymentMethodCommand extends Command
{
    protected static $defaultName = 'reepay:dev:add-payment-method';

    private const TEMPLATE = <<<PHP
<?php declare(strict_types=1);

namespace ReepayPayments\Handler\Method;

use ReepayPayments\Handler\ReepayHandler;

class __CLASSNAME__ extends ReepayHandler
{
    public function paymentMethodCode(): string
    {
        return '__CODE__';
    }

    public function paymentMethodName(): string
    {
        return '__NAME__';
    }
}
PHP;

    /**
     * @var FileLocator
     */
    private $fileLocator;

    public function __construct(
        FileLocator $fileLocator
    ) {
        parent::__construct();
        $this->fileLocator = $fileLocator;
    }

    protected function configure()
    {
        $this->addArgument('id')
            ->addArgument('description')
            ->setDescription('DEVELOPMENT/DEBUG ONLY');
    }

    public function run(InputInterface $input, OutputInterface $output)
    {
        $methodsDir = $this->fileLocator->locate('@ReepayPayments/Handler/Method');
        $paymentHandlersXml = $this->fileLocator->locate('@ReepayPayments/Resources/config/services/payment_handlers.xml');

        $className = $this->snakeToCamelCase((string) $input->getArgument('description')) . "PaymentType";
        $classFile = $methodsDir . '/' . $className . '.php';
        $classSource = $this->getClassSource(
            $className,
            (string) $input->getArgument('id'),
            (string) $input->getArgument('description')
        );
        file_put_contents($classFile, $classSource);

        $serviceDeclaration = $this->getServiceSource($className);
        $paymentHandlers = file_get_contents($paymentHandlersXml);
        $paymentHandlers = str_replace('</services>', $serviceDeclaration . '</services>', $paymentHandlers);
        file_put_contents($paymentHandlersXml, $paymentHandlers);

        return 0;
    }

    private function getClassSource(string $className, string $id, string $description): string
    {
        return str_replace(
            ['__CLASSNAME__', '__CODE__', '__NAME__'],
            [$className, $id, $description],
            self::TEMPLATE
        );
    }

    private function snakeToCamelCase($string)
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
    }

    private function getServiceSource(string $className): string
    {
        $template = <<<XML
<service id="ReepayPayments\Handler\Method\__CLASSNAME__">
    <tag name="shopware.payment.method.async" />
    <tag name="reepay_payments.handler" />
    <argument type="service" id="ReepayPayments\Service\Api\SessionApi"/>
    <argument type="service" id="ReepayPayments\Service\Api\InvoiceApi"/>
    <argument type="service" id="ReepayPayments\Service\PaymentStatusService"/>
</service>
XML;

        return str_replace('__CLASSNAME__', $className, $template);
    }
}
