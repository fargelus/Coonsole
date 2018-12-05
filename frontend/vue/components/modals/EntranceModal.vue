<template>
    <div class="modal entrance-modal bg-theme--snow">
        <div class="modal-mode entrance-modal__el">
            <h3 class="modal-mode__title">Вход</h3>
            <div class="modal-mode__delimeter">/</div>
            <h3 class="modal-mode__title modal-mode__title--option">Регистрация</h3>
        </div>

        <form class="entrance-modal__form entrance-modal__el">
            <input type="text" class="form-input entrance-modal__h-spacer interact-element" placeholder="Email">
            <div class="form-input--forgot-pwd">
                <span class="like-link forgot-link">Забыли?</span>
                <input type="text" class="form-input entrance-modal__h-spacer interact-element" placeholder="Пароль">
            </div>
            <ui-button type="submit" orange class="interact-element entrance-modal__button entrance-modal__button--submit">Войти</ui-button>
        </form>

        <div class="bg-theme--gallery-dark entrance-modal__el">
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

    export default Vue.extend({
        name: 'EntranceModal',
    });
</script>

<style lang="styl" type="text/stylus">
    .entrance-modal
        &__el
            padding: 25px 40px

        &__form
            display: flex
            padding-top: 0
            padding-bottom: 40px

        &__button.button
            align-items: center
            display: inline-flex
            padding: 5px 28px 5px 17px

        &__button--submit.button
            padding: 5px 20px

        &__h-spacer
            margin-right: 7px

        &__socials
            margin-top: 15px

    .modal.entrance-modal
        height: fit-content
        max-width: 815px
</style>
