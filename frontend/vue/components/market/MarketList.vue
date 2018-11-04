<template>
    <div class="market-list bg-theme--snow">
        <router-link class="market-list__item" v-for="link in itemsLink" :key="link" :to="'/item/' + link">
            <MarketItem/>
        </router-link>
    </div>
</template>

<script lang="ts">
    import Vue from 'vue';
    import MarketItem from './MarketItem.vue';

    declare module 'vue/types/vue' {
        interface Vue {
            // data
            itemsName: string[],
            itemsLink: string[],

            // methods
            fillItemsLink: () => void,
            getLinkFromName: (name: string) => string,
        }
    }

    export default Vue.extend({
        data(): object {
            return {
                name: 'Market',

                itemsName: [
                    'Fifa 19',
                    'Pro Evolution Soccer 2019',
                    'The Elder Scrolls III: Morrowind',
                    'Diablo III',
                    'The Last of Us',
                    'Tropico 5',
                    'Battlefield V',
                    'NBA 2K19',
                ],
                itemsLink: []
            };
        },

        components: {
            MarketItem,
        },

        mounted(): void {
            this.fillItemsLink();
        },

        methods: {
            fillItemsLink(): void {
                for (const itemName of this.itemsName) {
                    const link = this.getLinkFromName(itemName);
                    this.itemsLink.push(link);
                }
            },

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
            min-width: 206px

            &:not(:nth-child(4n))
                margin-right: 12px

            // Второй ряд
            &:nth-child(n + 5)
                margin-top: 24px
</style>
