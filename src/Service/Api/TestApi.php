<?php declare(strict_types=1);

namespace ReepayPayments\Service\Api;

use Psr\Log\LoggerInterface;
use Reepay\ApiException;
use ReepayPayments\Service\ReepayClientFactory;

class TestApi
{
    /**
     * @var ReepayClientFactory
     */
    private $factory;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        ReepayClientFactory $factory,
        LoggerInterface $logger
    ) {
        $this->factory = $factory;
        $this->logger = $logger;
    }

    public function testApiKey(string $apiKey): bool
    {
        $client = $this->factory->createApiClient($apiKey);

        try {
            $headerParams = [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($apiKey . ":")
            ];

            $client->callApi(
                '/v1/account',
                'GET',
                [],
                [],
                $headerParams
            );

            return true;
        } catch (ApiException $exception) {
            $this->logger->error('[InvoiceApi.settleInvoice] Error', [
                'exception' => [
                    'message' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine()
                ],
                'request' => [
                    'Authorization' => 'Basic ' . base64_encode($apiKey . ":")
                ],
                'response' => $exception->getResponseBody()
            ]);

            return false;
        }
    }
}
