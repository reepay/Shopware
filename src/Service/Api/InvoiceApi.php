<?php declare(strict_types=1);

namespace ReepayPayments\Service\Api;

use Psr\Log\LoggerInterface;
use Reepay\Api\InvoiceApi as ApiClient;
use Reepay\ApiException;
use Reepay\Model\Invoice;

class InvoiceApi
{
    /**
     * @var ApiClient
     */
    private $apiClient;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        ApiClient $apiClient,
        LoggerInterface $logger
    )
    {
        $this->apiClient = $apiClient;
        $this->logger = $logger;
    }

    public function getInvoice(string $id): Invoice
    {
        try {
            $response = $this->apiClient->getInvoice($id);

            $this->logger->debug('[InvoiceApi.getInvoice] Response', [
                'request' => [
                    'id' => $id
                ],
                'response' => $response
            ]);

            return $response;
        } catch (ApiException $exception) {
            $this->logger->error('[InvoiceApi.getInvoice] Error', [
                'exception' => [
                    'message' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine()
                ],
                'request' => [
                    'id' => $id
                ],
                'response' => $exception->getResponseBody()
            ]);
            throw $exception;
        }
    }

    public function settleInvoice(string $id): Invoice
    {
        try {
            $response = $this->apiClient->settle($id);

            $this->logger->debug('[InvoiceApi.settleInvoice] Response', [
                'request' => [
                    'id' => $id
                ],
                'response' => $response
            ]);

            return $response;
        } catch (ApiException $exception) {
            $this->logger->error('[InvoiceApi.settleInvoice] Error', [
                'exception' => [
                    'message' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine()
                ],
                'request' => [
                    'id' => $id
                ],
                'response' => $exception->getResponseBody()
            ]);
            throw $exception;
        }
    }
}
