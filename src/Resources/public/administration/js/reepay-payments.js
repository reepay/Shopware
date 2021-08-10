(this.webpackJsonp=this.webpackJsonp||[]).push([["reepay-payments"],{"+rzr":function(e,t,s){},IZto:function(e,t,s){var i=s("+rzr");"string"==typeof i&&(i=[[e.i,i,""]]),i.locals&&(e.exports=i.locals);(0,s("SZ7m").default)("484f3032",i,!0,{})},"f1c/":function(e,t,s){"use strict";s.r(t);var i=s("xllB"),a=s.n(i);s("IZto");const{Component:n,Mixin:o}=Shopware;n.extend("reepay-apikey-input","sw-text-field",{template:a.a,mixins:[o.getByName("notification")],props:{passwordToggleAble:{type:Boolean,required:!1,default:!0},placeholderIsPassword:{type:Boolean,required:!1,default:!1},autocomplete:{type:String,required:!1}},data:()=>({showPassword:!1,httpClient:null,isLoading:!1}),computed:{typeFieldClass(){return this.passwordToggleAble?"sw-field--password":"sw-field--password sw-field--password--untoggable"},passwordPlaceholder(){return this.showPassword||!this.placeholderIsPassword?this.placeholder:"*".repeat(this.placeholder.length?this.placeholder.length:6)}},created(){this.httpClient=Shopware.Service("syncService").httpClient},methods:{onTogglePasswordVisibility(e){e||(this.showPassword=!this.showPassword)},testApiKey(){this.isLoading=!0,this.httpClient.post("reepay-payments/test-api",{key:this.value}).then(e=>{this.isLoading=!1,e.data.apiKeyCorrect?this.createNotificationSuccess({title:this.$t("reepay-apikey-input.success"),message:this.$t("reepay-apikey-input.success-description")}):this.createNotificationError({title:this.$t("reepay-apikey-input.error"),message:this.$t("reepay-apikey-input.error-description")})})}}});var l=s("jasQ"),d=s.n(l);const{Component:p}=Shopware;p.extend("reepay-configuration-hidden","sw-text-field",{template:d.a});var r=s("vyuC"),c=s.n(r);const{Component:h}=Shopware;h.override("sw-settings-payment-detail",{template:c.a,watch:{paymentMethod(){this.paymentMethod.customFields||(this.paymentMethod.customFields={}),"1"!==this.paymentMethod.customFields.reepay_instant_settle&&(this.paymentMethod.customFields.reepay_instant_settle=!1),this.isReepayCheckoutMethod&&this.loadReepayMethods()}},computed:{isReepayMethod(){return!!this.paymentMethod&&this.paymentMethod.formattedHandlerIdentifier.startsWith("handler_reepaypayments_")},isReepayCheckoutMethod(){return!!this.paymentMethod&&"handler_reepaypayments_reepaycheckoutpaymenttype"===this.paymentMethod.formattedHandlerIdentifier}},data:()=>({reepayPaymentMethodsLoading:!1,reepayPaymentMethods:[]}),created(){this.loadReepayMethods()},methods:{loadReepayMethods(){0===this.reepayPaymentMethods.length?(this.reepayPaymentMethodsLoading=!0,this.httpClient||(this.syncService=Shopware.Service("syncService"),this.httpClient=this.syncService.httpClient),this.httpClient.get("/reepay-payments/method-options",{headers:this.syncService.getBasicHeaders()}).then(e=>{this.reepayPaymentMethods=e.data,this.reepayPaymentMethodsLoading=!1})):console.log("dfklfdl")}}})},jasQ:function(e,t){e.exports="{% block sw_text_field %}{% endblock %}\n"},vyuC:function(e,t){e.exports='{% block sw_settings_payment_detail_content_card %}\n    {% parent %}\n\n    <sw-card :title="$tc(\'sw-settings-payment-detail.reepay.cardTitle\')" v-if="isReepayMethod">\n        <sw-switch-field v-model="paymentMethod.customFields.reepay_instant_settle"\n                           :label="$tc(\'sw-settings-payment-detail.reepay.instantSettle\')">\n        </sw-switch-field>\n\n        <div v-if="isReepayCheckoutMethod">\n            <sw-multi-select label="Methods"\n                             :isLoading="reepayPaymentMethodsLoading"\n                             v-model="paymentMethod.customFields.reepay_payment_methods"\n                             :options="reepayPaymentMethods"></sw-multi-select>\n        </div>\n    </sw-card>\n{% endblock %}\n'},xllB:function(e,t){e.exports='{% block sw_password_field %}\n    {% block sw_text_field %}\n        <sw-contextual-field class="lr-apikey-input sw-field--password" v-bind="$attrs" :name="formFieldName">\n            <template #sw-field-input="{ identification, disabled, size, setFocusClass, removeFocusClass }">\n                <div class="sw-field--password__container">\n                    <input :type="showPassword ? \'text\' : \'password\'"\n                           :id="identification"\n                           :name="identification"\n                           :placeholder="passwordPlaceholder"\n                           :disabled="disabled"\n                           :value="currentValue"\n                           :autocomplete="autocomplete"\n                           @input="onInput"\n                           @change="onChange"\n                           @focus="setFocusClass"\n                           @blur="removeFocusClass"\n                           v-on="additionalListeners">\n                    <span v-if="passwordToggleAble" @click="onTogglePasswordVisibility(disabled)"\n                          :title="showPassword ? $tc(\'global.sw-field.titleHidePassword\') : $tc(\'global.sw-field.titleShowPassword\')"\n                          class="sw-field__toggle-password-visibility">\n                        <sw-icon v-if="showPassword" name="default-eye-crossed" small></sw-icon>\n\n                        <sw-icon v-else name="default-eye-open" small></sw-icon>\n                    </span>\n                </div>\n                <div class="sw-field--api-key__test">\n                    <sw-loader v-if="isLoading" class="lr-apikey-input-loader sw-select__select-indicator" size="16px"></sw-loader>\n                    <sw-button @click="testApiKey">{{ $tc(\'lr-apikey-input.test-button\') }}</sw-button>\n                </div>\n            </template>\n\n            <template v-if="copyable" #sw-contextual-field-suffix="{ identification }">\n                <sw-field-copyable\n                    v-if="copyable"\n                    :displayName="identification"\n                    :copyableText="currentValue"\n                    :tooltip="copyableTooltip">\n                </sw-field-copyable>\n            </template>\n        </sw-contextual-field>\n    {% endblock %}\n{% endblock %}\n\n'}},[["f1c/","runtime","vendors-node"]]]);