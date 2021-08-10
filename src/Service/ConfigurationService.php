<?php declare(strict_types=1);

namespace ReepayPayments\Service;

use Shopware\Core\System\SystemConfig\SystemConfigService;

class ConfigurationService
{
    public const CONFIG_PREFIX = 'ReepayPayments.config.';
    public const CONFIG_API_KEY_LIVE = 'apiKeyLive';
    public const CONFIG_API_KEY_TEST = 'apiKeyTest';
    public const CONFIG_API_ENABLE_TEST = 'enableTestMode';
    public const CONFIG_FIRST_SETUP_DONE = 'firstSetupDone';
    public const CONFIG_FAILED_WEBHOOK_EMAIL = 'failedWebhooksEmail';
    public const CONFIG_ORDER_PUSH_STATE = 'orderStateSettleInvoiceOnComplete';
    public const CONFIG_ORDER_STATE_CREATED = 'orderStateCreated';
    public const CONFIG_ORDER_STATE_PENDING = 'orderStatePending';
    public const CONFIG_ORDER_STATE_DUNNING = 'orderStateDunning';
    public const CONFIG_ORDER_STATE_SETTLED = 'orderStateSettled';
    public const CONFIG_ORDER_STATE_CANCELLED = 'orderStateCancelled';
    public const CONFIG_ORDER_STATE_AUTHORIZED = 'orderStateAuthorized';
    public const CONFIG_ORDER_STATE_FAILED = 'orderStateFailed';
    public const CONFIG_ORDER_STATE_NO_CHANGE_PLACEHOLDER = 'no_change';

    /**
     * @var SystemConfigService
     */
    private $systemConfigService;

    public function __construct(
        SystemConfigService $systemConfigService
    ) {
        $this->systemConfigService = $systemConfigService;
    }

    public function get(string $key, ?string $salesChannelId = null)
    {
        return $this->systemConfigService->get(
            self::CONFIG_PREFIX . $key,
            $salesChannelId
        );
    }

    public function getApiKey(?string $salesChannelId = null): string
    {
        if ($this->isTestMode($salesChannelId)) {
            return $this->getApiKeyTest($salesChannelId);
        }
        return $this->getApiKeyLive($salesChannelId);
    }

    public function getApiKeyLive(?string $salesChannelId = null): string
    {
        return $this->get(self::CONFIG_API_KEY_LIVE, $salesChannelId) ?? '';
    }

    public function getApiKeyTest(?string $salesChannelId = null): string
    {
        return $this->get(self::CONFIG_API_KEY_TEST, $salesChannelId) ?? '';
    }

    public function isTestMode(?string $salesChannelId = null): bool
    {
        return $this->get(self::CONFIG_API_ENABLE_TEST, $salesChannelId) ?? false;
    }

    public function isFirstSetupDone(?string $salesChannelId = null): bool
    {
        return (bool)$this->get(self::CONFIG_FIRST_SETUP_DONE, $salesChannelId);
    }

    public function getFailedWebhookEmail(?string $salesChannelId = null): string
    {
        return $this->get(self::CONFIG_FAILED_WEBHOOK_EMAIL, $salesChannelId) ?? '';
    }

    public function isOrderStateSettleInvoiceOnComplete(?string $salesChannelId = null): bool
    {
        return (bool)$this->get(self::CONFIG_ORDER_PUSH_STATE, $salesChannelId);
    }

    public function getOrderStateCreated(?string $salesChannelId = null): string
    {
        return (string)$this->get(self::CONFIG_ORDER_STATE_CREATED, $salesChannelId);
    }

    public function getOrderStatePending(?string $salesChannelId = null): string
    {
        return (string)$this->get(self::CONFIG_ORDER_STATE_PENDING, $salesChannelId);
    }

    public function getOrderStateDunning(?string $salesChannelId = null): string
    {
        return (string)$this->get(self::CONFIG_ORDER_STATE_DUNNING, $salesChannelId);
    }

    public function getOrderStateSettled(?string $salesChannelId = null): string
    {
        return (string)$this->get(self::CONFIG_ORDER_STATE_SETTLED, $salesChannelId);
    }

    public function getOrderStateCancelled(?string $salesChannelId = null): string
    {
        return (string)$this->get(self::CONFIG_ORDER_STATE_CANCELLED, $salesChannelId);
    }

    public function getOrderStateAuthorized(?string $salesChannelId = null): string
    {
        return (string)$this->get(self::CONFIG_ORDER_STATE_AUTHORIZED, $salesChannelId);
    }

    public function getOrderStateFailed(?string $salesChannelId = null): string
    {
        return (string)$this->get(self::CONFIG_ORDER_STATE_FAILED, $salesChannelId);
    }
}
