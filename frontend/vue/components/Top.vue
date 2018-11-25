<template>
    <div class="header-top">
        <div class="header-top__group">
            <router-link to="/">
                <img class="js-logo" width="138" height="36" alt="coonsole_logo">
            </router-link>

            <div class="site-search header-top__search interact-element">
                <input class="site-search__input interact-element bg-theme--gallery" type="text" :placeholder="enterSearchLabel">
                <ui-button class="site-search__button interact-element bg-theme--gallery">{{ findLabel }}</ui-button>
            </div>

            <button class="button interact-element group-button-last transparent header-top__button" type="button" @click="cityButtonClick">
                <img class="js-compass button__label-left">{{ userLocation }}
            </button>
        </div>

        <div class="header-top__group header-top__group--buttons interact-element">
            <ui-button snow>{{ saleLabel }}</ui-button>
            <ui-button class="header-top__button" orange @click="signInClick">{{ signInLabel }}</ui-button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                saleLabel: 'Продать',
                signInLabel: 'Войти',
                findLabel: 'Поиск',
                enterSearchLabel: 'Введите запрос',
                userLocation: 'Санкт-Петербург'
            };
        },

        props: {
            outerLocation: {
                type: String,
            },
        },

        watch: {
            /**
             * Если props изменился извне,
             * установим это значение, иначе возьмем текущее
             */
            outerLocation(newVal) {
                this.userLocation = newVal ? newVal : this.userLocation;
            }
        },

        methods: {
            cityButtonClick() {
                this.$emit('city-button-click');
            },

            signInClick() {
                this.$emit('sign-in-button-click');
            }
        },
    }
</script>

<style lang="styl" type="text/stylus">
    @require '../../styl/_variables'
    @require '../../styl/_mixins'

    /* Common Styles */
    .header-top, .header-top__group
        display: flex
        align-items: center

    /* End Of Common Styles */

    .header-top
        font-size: 16px
        padding: 16px 10px 14px 48px

    .header-top__group
        flex: 2 1 auto

        &--buttons
            align-items: stretch
            flex: 1 1 auto
            justify-content: flex-end

    .header-top__search
        margin-left: 75px
        flex: 1 1 auto

    .header-top__button
        margin-left: 20px

    .site-search
        position: relative
        max-width: 420px

    .site-search__input
        border-top-left-radius: 4px
        border-bottom-left-radius: 4px
        color: $masala
        font-size: 16px
        line-height: 2
        padding: 0 10px
        width: calc(100% - 73px)

    .button.site-search__button
        border-top-left-radius: 0
        border-bottom-left-radius: 0
        border-top-right-radius: 4px
        border-bottom-right-radius: 4px
        position: relative
        right: 2px
</style>
