<template>
    <div class="market-list">
        <Pagination v-if="isPagesMoreThanOne()"
                    @switch-page="getItemsFromPage"
                    :pages="pagesCount"
                    class="market-list__pagination">
        </Pagination>
        <div class="market-list__inner bg-theme--snow">
            <router-link class="market-list__item"
                         v-for="product in marketItems"
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
    import axios from 'axios';

    declare module 'vue/types/vue' {
        interface Vue {
            // props
            products_data: string[],
            products_group_count: string,

            // data
            pagesCount: number,

            // methods
            getLinkFromName: (name: string) => string,
        }
    }

    export default Vue.extend({
        name: 'Market',

        data(): object {
            return {
                marketItems: this.products_data,
                pagesCount: +this.products_group_count,
            };
        },

        props: {
            products_data: {
                type: Array,
                default: () => [],
            },

            products_group_count: {
                type: String,
                default: '',
            },
        },

        components: {
            MarketItem,
            Pagination,
        },

        methods: {
            getLinkFromName(name: string): string {
                return name.replace(/ /gi, '_').toLowerCase();
            },

            getItemsFromPage(page: number): void {
                const that: any = this;
                axios
                    .get(`/items/page/${page}`)
                    .then(response => that.marketItems = (response as any).data.paged_items);
            },

            isPagesMoreThanOne(): boolean {
                return this.pagesCount > 1;
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
