<template>
    <div>
        <form class="form" v-show="enterForm">
            <input type="text" class="form-input interact-element" placeholder="Email" v-focus>
            <div class="form-input--forgot-pwd">
                <span class="like-link forgot-link" @click="showForgotForm">Забыли?</span>
                <input type="text" class="form-input interact-element" placeholder="Пароль">
            </div>
            <ui-button type="submit" orange class="interact-element form__button--submit">Войти</ui-button>
        </form>

        <form class="form form--forgot-pwd" v-show="forgotForm">
            <input type="text" class="form-input interact-element" placeholder="Email" v-focus>
            <ui-button type="submit" orange class="interact-element form__button--submit form--forgot-pwd__submit">Восстановить пароль</ui-button>
        </form>
    </div>
</template>

<script lang="ts">
    import Vue from 'vue';

    export default Vue.extend({
        name: "Form",

        data() {
            return {
                enterForm: this.isEnterFormShow,
                forgotForm: false,
            }
        },

        props: {
            isEnterFormShow: {
                type: Boolean,
                default: true,
            }
        },

        methods: {
            showForgotForm(): void {
                this.enterForm = false;
                this.forgotForm = true;
                this.$emit('forgot-form');
            }
        },

        watch: {
            isEnterFormShow(newVal: boolean): void {
                this.enterForm = newVal;
                this.forgotForm = !newVal;
            }
        },
    });
</script>

<style lang="styl" type="text/stylus">
    .form
        display: flex

        &__button--submit.button
            padding: 5px 20px
            max-width: unset

        &--forgot-pwd
            flex-flow: column nowrap

            &__submit
                align-self: flex-start
                margin-top 10px
</style>
