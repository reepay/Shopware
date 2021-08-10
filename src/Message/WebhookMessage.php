<?php declare(strict_types=1);

namespace ReepayPayments\Message;

use Shopware\Core\Framework\Context;

class WebhookMessage
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var Context
     */
    private $context;

    public function __construct(
        array $data,
        Context $context
    ) {
        $this->data = $data;
        $this->context = $context;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getContext(): Context
    {
        return $this->context;
    }
}
