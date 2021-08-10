import template from './sw-settings-payment-detail.html.twig';

const { Component } = Shopware;

Component.override('sw-settings-payment-detail', {
    template,

    watch: {
        paymentMethod() {
            if (!this.paymentMethod.customFields) {
                this.paymentMethod.customFields = {};
            }

            if (this.paymentMethod.customFields.reepay_instant_settle !== "1") {
                this.paymentMethod.customFields.reepay_instant_settle = false;
            }

            if(this.isReepayCheckoutMethod) {
                this.loadReepayMethods();
            }
        },
    },

    computed: {
        isReepayMethod() {
            if (!this.paymentMethod) {
                return false;
            }

            return this.paymentMethod.formattedHandlerIdentifier.startsWith('handler_reepaypayments_');
        },

        isReepayCheckoutMethod() {
            if (!this.paymentMethod) {
                return false;
            }

            return this.paymentMethod.formattedHandlerIdentifier === 'handler_reepaypayments_reepaycheckoutpaymenttype';
        },

    },

    data() {
        return {
            reepayPaymentMethodsLoading: false,
            reepayPaymentMethods: []
        };
    },

    created() {
        this.loadReepayMethods();
    },

    methods: {
        loadReepayMethods() {
            if (this.reepayPaymentMethods.length !== 0) {
                console.log('dfklfdl');
                return;
            }

            this.reepayPaymentMethodsLoading = true;
            if (!this.httpClient) {
                this.syncService = Shopware.Service('syncService');
                this.httpClient = this.syncService.httpClient;
            }

            this.httpClient.get(
                `/reepay-payments/method-options`,
                { headers: this.syncService.getBasicHeaders() }
            ).then((response) => {
                this.reepayPaymentMethods = response.data;
                this.reepayPaymentMethodsLoading = false;
            });
        }
    }
});
