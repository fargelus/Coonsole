<template>
    <div class="modal entrance-modal bg-theme--snow" hidden>
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
            <ui-button type="submit" light_orange class="interact-element entrance-modal__button">Войти</ui-button>
        </form>

        <div class="bg-theme--gallery entrance-modal__el">
            <h3>Вход через социальные сети</h3>
            <div class="entrance-modal__socials">
                <ui-button sky class="interact-element entrance-modal__button entrance-modal__h-spacer">
                    Facebook
                </ui-button>
                <ui-button masala class="interact-element entrance-modal__button entrance-modal__h-spacer">
                    Google+
                </ui-button>
                <ui-button sky class="interact-element entrance-modal__button entrance-modal__h-spacer">
                    Вконтакте
                </ui-button>
                <ui-button light_orange class="interact-element entrance-modal__button">
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
            padding: 30px 40px

        &__form
            display: flex
            padding-top: 0
            padding-bottom: 40px

        &__button.button
            padding: 0 20px

        &__h-spacer
            margin-right: 7px

        &__socials
            margin-top: 15px

    .modal.entrance-modal
        height: fit-content
        max-width: 815px
</style>
