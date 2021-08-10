<?php declare(strict_types=1);

namespace ReepayPayments\Subscriber;

use ReepayPayments\Service\Api\AccountApi;
use ReepayPayments\Service\ConfigurationService;
use ReepayPayments\Setup\PaymentMethodSetup;
use Shopware\Core\Framework\DataAbstractionLayer\Event\EntityWrittenEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FirstSetupSubscriber implements EventSubscriberInterface
{
    const CONFIG_KEYS = [
        'ReepayPayments.config.apiKeyLive',
        'ReepayPayments.config.apiKeyTest',
        'ReepayPayments.config.failedWebhooksEmail'
    ];

    /**
     * @var AccountApi
     */
    private $accountApi;

    /**
     * @var ConfigurationService
     */
    private $configuration;

    /**
     * @var PaymentMethodSetup
     */
    private $paymentMethodSetup;

    public function __construct(
        AccountApi $accountApi,
        ConfigurationService $configuration,
        PaymentMethodSetup $paymentMethodSetup
    )
    {
        $this->accountApi = $accountApi;
        $this->configuration = $configuration;
        $this->paymentMethodSetup = $paymentMethodSetup;
    }

    public static function getSubscribedEvents()
    {
        return [
            'system_config.written' => 'firstSetup'
        ];
    }

    public function firstSetup(EntityWrittenEvent $event)
    {
        $shouldUpdate = false;
        foreach ($event->getWriteResults() as $writeResult) {
            $payload = $writeResult->getPayload();
            if (!in_array($payload['configurationKey'], self::CONFIG_KEYS)) {
                continue;
            }

            $shouldUpdate = true;
        }

        if ($shouldUpdate) {
            try {
                $this->accountApi->updateAccountWebhooks();
            } catch (\Exception $exception) {
                //ignore
            }
            try {
                $this->paymentMethodSetup->loadPaymentMethods(
                    $event->getContext()
                );
            } catch (\Exception $exception) {
                //ignore
            }
        }
    }
}
