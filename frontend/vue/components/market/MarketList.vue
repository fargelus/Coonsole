<template>
    <div class="market-list bg-theme--snow">
        <div class="market-list__item" v-for="n in 8">
            <router-link to="/item">
                <MarketItem/>
            </router-link>
        </div>
    </div>
</template>

<script lang="ts">
    import Vue from 'vue';
    import MarketItem from './MarketItem.vue';

    export default Vue.extend({
        data() {
            return {
                name: 'Market',
            };
        },

        components: {
            MarketItem,
        },
    });
</script>

<style lang="styl" type="text/stylus">
    @require "../../../styl/_variables"

    .market-list
        display: flex
        flex-flow: row wrap

        &__item
            min-width: 206px

            &:not(:nth-child(4n))
                margin-right: 12px

            // Второй ряд
            &:nth-child(n + 5)
                margin-top: 24px
</style>
