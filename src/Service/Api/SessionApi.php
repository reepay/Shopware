<?php declare(strict_types=1);

namespace ReepayPayments\Service\Api;

use Psr\Log\LoggerInterface;
use Reepay\Api\SessionApi as ApiClient;
use Reepay\Model\CreateSession;
use Reepay\Model\Session;
use Shopware\Core\Checkout\Customer\CustomerEntity;
use Shopware\Core\Checkout\Order\Aggregate\OrderTransaction\OrderTransactionEntity;
use Shopware\Core\Checkout\Order\OrderEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Exception\EntityNotFoundException;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;

class SessionApi
{
    /**
     * @var ApiClient
     */
    private $apiClient;

    /**
     * @var EntityRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        ApiClient $apiClient,
        EntityRepositoryInterface $customerRepository,
        LoggerInterface $logger
    )
    {
        $this->apiClient = $apiClient;
        $this->customerRepository = $customerRepository;
        $this->logger = $logger;
    }

    public function createSession(OrderEntity $order, OrderTransactionEntity $transaction, string $redirectUrl, string $paymentMethod, Context $context): Session
    {
        $customer = $this->getOrderCustomer($order, $context);
        $instantSettle = $transaction->getPaymentMethod()->getCustomFields()['reepay_instant_settle'] ?? false;
        $vatId = $this->getVatId($order);

        $data = [
            'order' => [
                'handle' => $transaction->getId(),
                'amount' => $transaction->getAmount()->getTotalPrice() * 100,
                'currency' => 'EUR',
                'customer' => [
                    'email' => $order->getOrderCustomer()->getEmail(),
                    'phone' => $customer->getDefaultBillingAddress()->getPhoneNumber(),
                    'handle' => $order->getOrderCustomer()->getCustomerNumber(),
                    'first_name' => $order->getOrderCustomer()->getFirstName(),
                    'last_name' => $order->getOrderCustomer()->getLastName(),
                    'address' => $customer->getDefaultBillingAddress()->getStreet(),
                    'address2' => $customer->getDefaultBillingAddress()->getAdditionalAddressLine1(),
                    'postal_code' => $customer->getDefaultBillingAddress()->getZipcode(),
                    'city' => $customer->getDefaultBillingAddress()->getCity(),
                    'country' => $customer->getDefaultBillingAddress()->getCountry()->getIso(),
                ],
                'billing_address' => [
                    'email' => $order->getOrderCustomer()->getEmail(),
                    'phone' => $customer->getDefaultBillingAddress()->getPhoneNumber(),
                    'company' => $customer->getDefaultBillingAddress()->getCompany(),
                    'vat' => $vatId,
                    'first_name' => $customer->getDefaultBillingAddress()->getFirstName(),
                    'last_name' => $customer->getDefaultBillingAddress()->getLastName(),
                    'address' => $customer->getDefaultBillingAddress()->getStreet(),
                    'address2' => $customer->getDefaultBillingAddress()->getAdditionalAddressLine1(),
                    'postal_code' => $customer->getDefaultBillingAddress()->getZipcode(),
                    'city' => $customer->getDefaultBillingAddress()->getCity(),
                    'country' => $customer->getDefaultBillingAddress()->getCountry()->getIso(),
                ],
                'shipping_address' => [
                    'email' => $order->getOrderCustomer()->getEmail(),
                    'phone' => $customer->getDefaultShippingAddress()->getPhoneNumber(),
                    'company' => $customer->getDefaultShippingAddress()->getCompany(),
                    'vat' => $vatId,
                    'first_name' => $customer->getDefaultShippingAddress()->getFirstName(),
                    'last_name' => $customer->getDefaultShippingAddress()->getLastName(),
                    'address' => $customer->getDefaultShippingAddress()->getStreet(),
                    'address2' => $customer->getDefaultShippingAddress()->getAdditionalAddressLine1(),
                    'postal_code' => $customer->getDefaultShippingAddress()->getZipcode(),
                    'city' => $customer->getDefaultShippingAddress()->getCity(),
                    'country' => $customer->getDefaultShippingAddress()->getCountry()->getIso(),
                ]
            ],
            'settle' => $instantSettle === "1",
            'accept_url' => $redirectUrl,
            'cancel_url' => $redirectUrl . '&cancel=true',
            'recurring' => false,
            'locale' => $this->getReepayLocale($customer),
            'payment_methods' => [$paymentMethod],
        ];

        if ($phoneNumber = $customer->getDefaultBillingAddress()->getPhoneNumber()) {
            $data['order']['customer']['phone'] = $phoneNumber;
            $data['order']['billing_address']['phone'] = $phoneNumber;
        }

        if ($phoneNumber = $customer->getDefaultShippingAddress()->getPhoneNumber()) {
            $data['order']['shipping_address']['phone'] = $phoneNumber;
        }

        if ($countryState = $customer->getDefaultBillingAddress()->getCountryState()) {
            $data['order']['customer']['state_or_province'] = $countryState->getName();
            $data['order']['billing_address']['state_or_province'] = $countryState->getName();
        }

        if ($countryState = $customer->getDefaultShippingAddress()->getCountryState()) {
            $data['order']['shipping_address']['state_or_province'] = $countryState->getName();
        }

        if (empty($paymentMethod)) {
            if (($methods = $transaction->getPaymentMethod()->getCustomFields()['reepay_payment_methods'] ?? []) && !empty($methods)) {
                $data['payment_methods'] = $methods;
            } else {
                unset($data['payment_methods']);
            }
        }

        $this->logger->debug('SessionApi. Creating session with data', $data);

        return $this->apiClient->createSession(new CreateSession($data));
    }

    private function getOrderCustomer(OrderEntity $order, Context $context): CustomerEntity
    {
        $criteria = new Criteria([$order->getOrderCustomer()->getCustomerId()]);
        $criteria->addAssociations([
            'defaultBillingAddress',
            'defaultBillingAddress.country',
            'defaultBillingAddress.countryState',
            'defaultShippingAddress',
            'defaultShippingAddress.country',
            'defaultShippingAddress.countryState',
            'language',
            'language.locale'
        ]);
        $customer = $this->customerRepository->search($criteria, $context)->first();

        if (!$customer) {
            throw new EntityNotFoundException('customer', $order->getOrderCustomer()->getCustomerId());
        }

        return $customer;
    }

    private function getReepayLocale(CustomerEntity $customer)
    {
        // TODO: Add filtering for Reepay locales
        return str_replace('-', '_', $customer->getLanguage()->getLocale()->getCode());
    }

    /**
     * Get vat id from order customer entity
     *
     * Since SW 6.4.0.0 Vat id is no longer available in 'customer address' entities.
     * And available in 'customer' entity, so after order it will be available in 'order customer' entity
     *
     * @param OrderEntity $order
     *
     * @return string|null
     */
    private function getVatId(OrderEntity $order): ?string
    {
        if (!$order->getOrderCustomer()) {
            return null;
        }

        $vatIds = $order->getOrderCustomer()->getVatIds();

        if (!$vatIds) {
            return null;
        }

        foreach ($vatIds as $vatId) {
            return $vatId; // get first vat id
        }

        return null;
    }
}
