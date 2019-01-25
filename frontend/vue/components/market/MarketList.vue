<template>
    <div class="market-list">
        <Pagination class="market-list__pagination"></Pagination>
        <div class="market-list__inner bg-theme--snow">
            <router-link class="market-list__item"
                         v-for="product in productsData"
                         :key="product.id"
                         :to="{
                            name: 'MarketItemDetail',
                            params: {
                                link: getLinkFromName(product.name),
                                detailData: {
                                    name: product.name,
                                    price: product.price,
                                }
                            },
                         }">
                <MarketItem
                    :title="product.name"
                    :price="product.price"
                    :releaseDate="product.date_updated"></MarketItem>
            </router-link>
        </div>
    </div>
</template>

<script lang="ts">
    import Vue from 'vue';
    import MarketItem from './MarketItem.vue';
    import Pagination from '../Pagination.vue';

    declare module 'vue/types/vue' {
        interface Vue {
            // methods
            getLinkFromName: (name: string) => string,
        }
    }

    export default Vue.extend({
        name: 'Market',

        data(): object {
            return {};
        },

        props: {
          productsData: {
              type: Array,
              default: () => [],
          },
        },

        components: {
            MarketItem,
            Pagination,
        },

        methods: {
            getLinkFromName(name: string): string {
                return name.replace(/ /gi, '_').toLowerCase();
            }
        },
    });
</script>

<style lang="styl" type="text/stylus">
    @require "../../../styl/_variables"

    .market-list
        display: flex
        flex-flow: column nowrap

        &__inner
            display: flex
            flex-flow: row wrap
            flex: 1 1 auto
            position: relative
            padding: 23px 0 23px 29px

        &__item
            flex: 0 1 205px
            max-height: 260px

            &:not(:nth-child(4n))
                margin-right: 12px

            // Второй ряд
            &:nth-child(n + 5)
                margin-top: 24px
</style>
