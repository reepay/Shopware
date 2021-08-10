<?php declare(strict_types=1);

namespace ReepayPayments\Service\Api;

use Psr\Log\LoggerInterface;
use Reepay\Api\AccountApi as ApiClient;
use Reepay\ApiException;
use ReepayPayments\Service\ConfigurationService;
use Symfony\Component\Routing\RouterInterface;

class AccountApi
{
    /**
     * @var ApiClient
     */
    private $apiClient;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var ConfigurationService
     */
    private $configurationService;

    public function __construct(
        ApiClient $apiClient,
        RouterInterface $router,
        LoggerInterface $logger,
        ConfigurationService $configurationService
    ) {
        $this->apiClient = $apiClient;
        $this->router = $router;
        $this->logger = $logger;
        $this->configurationService = $configurationService;
    }

    public function updateAccountWebhooks(): void
    {
        try {
            $url = $this->router->generate('frontend.reepay.webhook', [], RouterInterface::ABSOLUTE_URL);

            $webhookSettings = $this->apiClient->getWebhookSettings();
            $webhookSettings->setUrls(array_values(array_unique(array_merge($webhookSettings->getUrls(), [$url]))));
            if (($alertEmail = $this->configurationService->getFailedWebhookEmail()) && !empty($alertEmail)) {
                $webhookSettings->setAlertEmails(array_values(array_unique(array_merge($webhookSettings->getAlertEmails(), [$alertEmail]))));
            }

            $this->apiClient->updateWebhookSettingsJson($webhookSettings);
        } catch (ApiException $exception) {
            $this->logger->error('[AccountApi.updateAccountWebhooks] Error', [
                'exception' => [
                    'message' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine()
                ],
                'response' => $exception->getResponseBody()
            ]);

            throw $exception;
        }
    }
}
