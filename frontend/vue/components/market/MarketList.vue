<template>
    <div class="market-list bg-theme--snow">
        <router-link class="market-list__item"
                     v-for="product in productsData"
                     :key="product.id"
                     :to="{
                        name: 'MarketItemDetail',
                        params: {
                            link: getLinkFromName(product.name),
                            detailData: {
                                name: product.name,
                            }
                        },
                     }">
            <MarketItem :title="product.name"></MarketItem>
        </router-link>
    </div>
</template>

<script lang="ts">
    import Vue from 'vue';
    import MarketItem from './MarketItem.vue';

    declare module 'vue/types/vue' {
        interface Vue {
            // methods
            getLinkFromName: (name: string) => string,
        }
    }

    export default Vue.extend({
        name: 'Market',

        data(): object {
            return {
                // Более реалистичная модель данных
                productsData: [
                    {
                        id: 1,
                        name: 'Fifa 19',
                    },
                    {
                        id: 2,
                        name: 'Pro Evolution Soccer 2019',
                    },
                    {
                        id: 3,
                        name: 'The Elder Scrolls III: Morrowind',
                    },
                    {
                        id: 4,
                        name: 'Diablo III',
                    },
                    {
                        id: 5,
                        name: 'The Last of Us',
                    },
                    {
                        id: 6,
                        name: 'Tropico 5',
                    },
                    {
                        id: 7,
                        name: 'Battlefield V',
                    },
                    {
                        id: 8,
                        name: 'NBA 2K19'
                    }
                ],
            };
        },

        components: {
            MarketItem,
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
        flex-flow: row wrap

        &__item
            flex: 0 1 205px

            &:not(:nth-child(4n))
                margin-right: 12px

            // Второй ряд
            &:nth-child(n + 5)
                margin-top: 24px
</style>
