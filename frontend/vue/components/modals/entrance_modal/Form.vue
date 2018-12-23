<template>
    <div>
        <form class="form" v-show="enterForm">
            <input type="email" class="form-input interact-element" :placeholder=emailPlaceholder v-focus required>
            <div class="form-input--forgot-pwd">
                <span class="like-link forgot-link" @click="forgotFormModeSelect">{{forgotPwdText}}</span>
                <PasswordInput></PasswordInput>
            </div>
            <ui-button type="submit" orange class="interact-element form__button--submit">{{enterBtnText}}</ui-button>
        </form>

        <form class="form form--forgot-pwd" v-show="forgotForm">
            <input type="email" class="form-input interact-element" :placeholder=emailPlaceholder v-focus required>
            <ui-button type="submit" orange class="interact-element form__button--submit form--forgot-pwd__submit form__vspacer">{{restorePwdText}}</ui-button>
        </form>

        <form class="form" v-show="regForm">
            <input type="email" class="form-input interact-element" :placeholder=emailPlaceholder v-focus required>
            <input type="text" class="form-input interact-element" :placeholder=namePlaceholder required>
            <PasswordInput></PasswordInput>
            <vue-recaptcha
                class="form__recaptcha"
                id="recaptcha"
                sitekey="6LepRIQUAAAAACafzCaHZ45D5Ef9LP3A3QrQg377"
                @verify="recapthaVerified"></vue-recaptcha>
            <ui-button type="submit" :class="{
                'button--disabled': !isCaptchaVerified,
            }" orange class="interact-element form__button--submit form__vspacer">{{regBtnText}}</ui-button>
        </form>
    </div>
</template>

<script lang="ts">
    import Vue from 'vue';
    import PasswordInput from './PasswordInput.vue';
    import VueRecaptcha from 'vue-recaptcha';

    export default Vue.extend({
        name: "Form",

        data() {
            return {
                enterForm: this.isEnterFormShow,
                emailPlaceholder: 'Email',
                forgotPwdText: 'Забыли?',
                enterBtnText: 'Войти',
                forgotForm: this.isForgotFormShow,
                restorePwdText: 'Восстановить пароль',
                regForm: this.isRegFormShow,
                namePlaceholder: 'Ваше имя',
                regBtnText: 'Зарегистрироваться',
                isCaptchaVerified: false,
            }
        },

        props: {
            isEnterFormShow: {
                type: Boolean,
                default: true,
            },

            isRegFormShow: {
                type: Boolean,
                default: false,
            },

            isForgotFormShow: {
                type: Boolean,
                default: false,
            }
        },

        methods: {
            forgotFormModeSelect(): void {
                this.$emit('forgot-form');
            },

            recapthaVerified(): void {
                this.isCaptchaVerified = true;
            },
        },

        watch: {
            isEnterFormShow(newVal: boolean): void {
                this.enterForm = newVal;
            },

            isRegFormShow(newVal: boolean): void {
                this.regForm = newVal;
            },

            isForgotFormShow(newVal: boolean): void {
                this.forgotForm = newVal;
            },
        },

        components: {
            PasswordInput,
            VueRecaptcha,
        }
    });
</script>

<style lang="styl" type="text/stylus">
    .form
        display: flex
        flex-wrap: wrap

        &__button--submit.button
            padding: 5px 20px
            max-width: unset

        &__vspacer
            margin-top 10px

        &--forgot-pwd
            flex-flow: column nowrap

            &__submit
                align-self: flex-start

        &__recaptcha
            flex: 1 1 100%
            margin: 15px 0 5px
</style>
