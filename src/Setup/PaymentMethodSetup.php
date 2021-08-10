<?php declare(strict_types=1);

namespace ReepayPayments\Setup;

use ReepayPayments\Handler\ReepayHandler;
use ReepayPayments\ReepayPayments;
use Shopware\Core\Content\Media\MediaCollection;
use Shopware\Core\Content\Media\MediaService;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Plugin\Util\PluginIdProvider;
use Shopware\Core\Framework\Uuid\Uuid;

class PaymentMethodSetup
{
    /**
     * @var iterable|ReepayHandler[]
     */
    private $paymentHandlers;

    /**
     * @var EntityRepositoryInterface
     */
    private $paymentMethodRepository;
    /**
     * @var PluginIdProvider
     */
    private $pluginIdProvider;
    /**
     * @var EntityRepositoryInterface
     */
    private $mediaRepository;
    /**
     * @var MediaService
     */
    private $mediaService;

    public function __construct(
        iterable $paymentHandlers,
        EntityRepositoryInterface $paymentMethodRepository,
        PluginIdProvider $pluginIdProvider,
        EntityRepositoryInterface $mediaRepository,
        MediaService $mediaService
    ) {
        $this->paymentHandlers = $paymentHandlers;
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->pluginIdProvider = $pluginIdProvider;
        $this->mediaRepository = $mediaRepository;
        $this->mediaService = $mediaService;
    }

    public function loadPaymentMethods(Context $context): void
    {
        $upsert = [];
        $pluginId = $this->pluginIdProvider->getPluginIdByBaseClass(ReepayPayments::class, $context);

        foreach ($this->paymentHandlers as $handler) {
            $upsert[] = [
                'id' => $this->getPaymentMethodId(get_class($handler), $context),
                'handlerIdentifier' => get_class($handler),
                'name' => 'Reepay - ' . $handler->paymentMethodName(),
                'description' => '',
                'pluginId' => $pluginId,
                'mediaId' => $this->getMedia($handler, $context),
                'customFields' => [
                    'reepay_payment_method_code' => $handler->paymentMethodCode(),
                ],
            ];
        }

        if (!empty($upsert)) {
            $this->paymentMethodRepository->upsert($upsert, $context);
        }
    }

    private function getPaymentMethodId(string $handler, Context $context): string
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('handlerIdentifier', $handler));
        $id = $this->paymentMethodRepository->searchIds($criteria, $context)->firstId();

        if ($id) {
            return $id;
        }

        return Uuid::randomHex();
    }

    private function getMedia(ReepayHandler $handler, Context $context): ?string
    {
        $mediaFilename = 'logo_reepay_' . $handler->paymentMethodCode();

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('fileName', $mediaFilename));

        /** @var MediaCollection $icons */
        $icons = $this->mediaRepository->search($criteria, $context);

        if ($icons->first() !== null) {
            return $icons->first()->getId();
        }

        $fileName = $handler->paymentMethodCode() . '.png';

        if (empty($handler->paymentMethodCode())) {
            $fileName = 'reepay.png';
        }

        $filePath = __DIR__ . '/../Resources/assets/' . $fileName;

        if (!file_exists($filePath)) {
            return null;
        }

        return $this->mediaService->saveFile(
            file_get_contents($filePath),
            'png',
            'image/png',
            $mediaFilename,
            $context,
            'Reepay Media',
            null,
            false
        );
    }
}
