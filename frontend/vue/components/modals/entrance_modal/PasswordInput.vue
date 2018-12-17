<template>
    <div class="password-input">
        <input :type="currentType" class="form-input interact-element" :placeholder=pwdPlaceholder v-model="passwordText">
        <div class="password-input__icons">
            <font-awesome-icon v-show="passwordText && !isReveal" class="icon" width="22" height="16" icon="eye-slash" @click="revealPwd" />
            <font-awesome-icon v-show="passwordText && isReveal" class="icon" width="22" height="16" icon="eye" @click="encryptPwd"/>
        </div>
    </div>
</template>

<script lang="ts">
    import Vue from 'vue';

    export default Vue.extend({
        name: "PasswordInput",

        data() {
            return {
                currentType: 'password',
                pwdPlaceholder: 'Пароль',
                isReveal: false,
                passwordText: '',
            }
        },

        methods: {
            revealPwd() {
                this.currentType = 'text';
                this.isReveal = true;
            },

            encryptPwd() {
                this.currentType = 'password';
                this.isReveal = false;
            }
        }
    });
</script>

<style lang="styl" type="text/stylus">
    .password-input
        position: relative

        &__icons
            position: absolute
            top: 8px
            right: 15px
            cursor: pointer
</style>
