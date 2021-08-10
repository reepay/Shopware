<?php declare(strict_types=1);

namespace ReepayPayments\Service;

use Reepay\Api\AccountApi;
use Reepay\Api\InvoiceApi;
use Reepay\Api\SessionApi;
use Reepay\ApiClient;
use Reepay\Configuration;

class ReepayClientFactory
{
    /**
     * @var ConfigurationService
     */
    private $configuration;

    /**
     * @var ApiClient
     */
    private $client;

    /**
     * @var ApiClient
     */
    private $checkoutClient;

    public function __construct(
        ConfigurationService $configuration
    )
    {
        $this->configuration = $configuration;
    }

    public function createApiClient(?string $apiKey = null): ApiClient
    {
        if (!$this->client) {
            $configuration = new Configuration();
            $configuration->setUsername($apiKey ?? $this->configuration->getApiKey());

            $this->client = new ApiClient($configuration);
        }

        return $this->client;
    }

    public function createCheckoutApiClient(): ApiClient
    {
        if (!$this->checkoutClient) {
            $configuration = new Configuration();
            $configuration->setUsername($this->configuration->getApiKey());
            $configuration->setHost('https://checkout-api.reepay.com');

            $this->checkoutClient = new ApiClient($configuration);
        }

        return $this->checkoutClient;
    }

    public function createAccountApi(): AccountApi
    {
        return new AccountApi($this->createApiClient());
    }

    public function createInvoiceApi(): InvoiceApi
    {
        return new InvoiceApi($this->createApiClient());
    }

    public function createSessionApi(): SessionApi
    {
        return new SessionApi($this->createCheckoutApiClient());
    }
}
