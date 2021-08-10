import template from './reepay-apikey-input.html.twig';
import './reepay-apikey-input.scss';

const { Component, Mixin } = Shopware;

Component.extend('reepay-apikey-input', 'sw-text-field', {
    template,

    mixins: [
        Mixin.getByName('notification')
    ],

    props: {
        passwordToggleAble: {
            type: Boolean,
            required: false,
            default: true
        },

        placeholderIsPassword: {
            type: Boolean,
            required: false,
            default: false
        },

        autocomplete: {
            type: String,
            required: false
        }
    },

    data() {
        return {
            showPassword: false,
            httpClient: null,
            isLoading: false,
        };
    },

    computed: {
        typeFieldClass() {
            return this.passwordToggleAble ? 'sw-field--password' : 'sw-field--password sw-field--password--untoggable';
        },

        passwordPlaceholder() {
            return this.showPassword ||
            !this.placeholderIsPassword ?
                this.placeholder :
                '*'.repeat(this.placeholder.length ? this.placeholder.length : 6);
        }
    },

    created() {
        this.httpClient = Shopware.Service('syncService').httpClient;
    },

    methods: {
        onTogglePasswordVisibility(disabled) {
            if (disabled) {
                return;
            }

            this.showPassword = !this.showPassword;
        },

        testApiKey() {
            this.isLoading = true;
            this.httpClient.post('reepay-payments/test-api', {
                key: this.value
            }).then((response) => {
                this.isLoading = false;
                if (response.data.apiKeyCorrect) {
                    this.createNotificationSuccess({
                        title: this.$t('reepay-apikey-input.success'),
                        message: this.$t('reepay-apikey-input.success-description')
                    });
                    return;
                }

                this.createNotificationError({
                    title: this.$t('reepay-apikey-input.error'),
                    message: this.$t('reepay-apikey-input.error-description')
                });
            });
        }
    }
});
