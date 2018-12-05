<template>
    <div class="market-item">
        <div class="poster-wrapper bg-theme--gallery"></div>
        <div class="market-item__caption top-line--masala border-theme--gallery">
            <h3 class="market-item__title">{{ title }}</h3>
            <div class="market-item__bottom">
                <span class="market-item__release-date">{{ getDaysPassedPhrase() }}</span>
                <span class="market-item__price">{{ price }}&nbsp;
                    <span class="market-item__currency">&#8381;</span>
                </span>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import Vue from 'vue';
    import DaysPassed from '../../../ts/ui/days-passed.ts';

    export default Vue.extend({
        name: 'MarketItem',

        data() {
            return {
                daysPassed: new DaysPassed(this.releaseDate).getValue(),
            }
        },

        methods: {
            getDayWord(): string {
                const lastDigit: number = this.daysPassed % 10;
                const hundreds: number = parseInt('' + this.daysPassed / 10, 10) % 10;

                if (lastDigit >= 5 || lastDigit === 0 || hundreds === 1) {
                    return 'дней';
                }
                return lastDigit >= 2 ? 'дня' : 'день';
            },

            getDaysPassedPhrase(): string {
                return `${this.daysPassed} ${this.getDayWord()} назад`;
            }
        },

        props: {
            title: {
                type: String,
                default: '',
            },
            price: {
                type: Number,
                default: 0,
            },
            releaseDate: {
                type: String,
                default: ''
            }
        },
    });
</script>

<style lang="styl" type="text/stylus">
    @require "../../../styl/_variables"

    .market-item, .market-item__caption
        display: flex
        flex-direction: column

    .market-item__title, .market-item__price
        font-size: 17px
        line-height: 1.16

    .market-item
        cursor: pointer
        font-family: RobotoCondensed
        height: 100%

        &:hover
            & .top-line--masala::before
                background-color: $blaze-orange

        &__caption
            justify-content: space-between
            padding: 12px
            border-bottom-left-radius: 4px
            border-bottom-right-radius: 4px
            min-height: 95px

            &.top-line--masala
                position: relative

                &::before
                    position: absolute
                    width: 100%

        &__title
            font-family: inherit
            margin-top: 3px

        &__bottom
            display: flex
            margin-top: 10px
            justify-content: space-between
            align-items: center

        &__release-date
            font-size: 12px
            line-height: 1.16

        &__currency
            font-size: 15px

        .poster-wrapper
            width: 100%
            flex: 1 1 75%
</style>
