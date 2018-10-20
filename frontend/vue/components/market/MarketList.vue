<template>
    <div class="market-list">
        <div class="market-list__item" v-for="n in 8">
            <router-link to="/item">
                <MarketItem/>
            </router-link>
        </div>
    </div>
</template>

<script>
    import MarketItem from './MarketItem.vue';

    export default {
        data() {
            return {
                name: 'Market',
            };
        },

        components: {
            MarketItem,
        },
    }
</script>

<style lang="styl" type="text/stylus">
    @require "../../../styl/_variables"

    .market-list
        background-color: $snow
        display: flex
        flex-flow: row wrap

        &__item
            margin-top: 32px
            min-width: 200px

            &:not(:nth-child(4n))
                margin-right: 12px
</style>
