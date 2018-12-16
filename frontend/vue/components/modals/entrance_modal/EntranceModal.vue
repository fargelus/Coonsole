<template>
    <div class="modal entrance-modal bg-theme--snow"
         :class="{
            'forgot-password-order': isSwitchedToForgotForm,
        }">

        <div class="modal-mode entrance-modal__mode entrance-modal__el">
            <h3 class="modal-mode__title"
                :class="{
                    'modal-mode__title--option': isSwitchedToForgotForm || isSwitchedToRegForm,
                }"
                @click="switchToEnterForm"> Вход </h3>
            <div class="modal-mode__delimeter">/</div>
            <h3 class="modal-mode__title"
                :class="{
                    'modal-mode__title--option': !isSwitchedToRegForm,
                }"
                @click="switchToRegForm">Регистрация
            </h3>
        </div>

        <h3 class="modal-mode__title entrance-modal__el" v-show="isSwitchedToForgotForm"> Восстановление пароля </h3>

        <Form class="entrance-modal__form entrance-modal__el"
              :isEnterFormShow="isSwitchedToEnterForm"
              :isForgotFormShow="isSwitchedToForgotForm"
              :isRegFormShow="isSwitchedToRegForm"
              @forgot-form="switchToForgotForm"
        ></Form>

        <div class="bg-theme--gallery-dark entrance-modal__socials-wrapper entrance-modal__el">
            <h3>Вход через социальные сети</h3>
            <div class="entrance-modal__socials">
                <ui-button sky class="entrance-modal__button entrance-modal__h-spacer">
                    <font-awesome-icon class="icon button__icon" width="30" height="23" :icon="['fab', 'facebook-f']" />
                    Facebook
                </ui-button>
                <ui-button masala class="entrance-modal__button entrance-modal__h-spacer">
                    <font-awesome-icon class="icon button__icon" width="30" height="23" :icon="['fab', 'google-plus']" />
                    Google+
                </ui-button>
                <ui-button vk class="entrance-modal__button entrance-modal__h-spacer">
                    <font-awesome-icon class="icon button__icon" width="30" height="23" :icon="['fab', 'vk']" />
                    Вконтакте
                </ui-button>
                <ui-button twitter class="entrance-modal__button">
                    <font-awesome-icon class="icon button__icon" width="30" height="23" :icon="['fab', 'twitter']" />
                    Twitter
                </ui-button>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import Vue from 'vue';
    import Form from './Form.vue';

    export default Vue.extend({
        name: 'EntranceModal',

        data() {
            return {
                isSwitchedToEnterForm: true,
                isSwitchedToRegForm: false,
                isSwitchedToForgotForm: false,
            }
        },

        methods: {
            switchToEnterForm(): void {
                this.isSwitchedToEnterForm = true;
                this.isSwitchedToRegForm = this.isSwitchedToForgotForm = false;
            },

            switchToRegForm(): void {
                this.isSwitchedToRegForm = true;
                this.isSwitchedToEnterForm = this.isSwitchedToForgotForm = false;
            },

            switchToForgotForm(): void {
                this.isSwitchedToForgotForm = true;
                this.isSwitchedToEnterForm = this.isSwitchedToEnterForm = false;
            },
        },

        components: {
            Form,
        }
    });
</script>

<style lang="styl" type="text/stylus">
    .entrance-modal
        &__el
            padding: 25px 40px

        &__form
            padding-top: 0
            padding-bottom: 40px

            input
                margin-right: 7px

        &__h-spacer
            margin-right: 7px

        &__socials
            margin-top: 15px

        &__button.button
            align-items: center
            display: inline-flex
            padding: 5px 28px 5px 17px

    .modal.entrance-modal
        height: fit-content
        max-width: 815px
        display: flex
        flex-direction: column

    .forgot-password-order
        .entrance-modal__mode
            order: 2
            padding-top: 0
            padding-bottom: 15px

        .entrance-modal__form
            padding-bottom: 20px

        .entrance-modal__socials-wrapper
            order: 3
</style>
