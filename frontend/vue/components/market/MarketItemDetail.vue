<template>
    <div class="item-detail-wrapper bg-theme--snow">
        <div class="item-detail item-detail-wrapper__content">
            <div class="item-detail-top item-detail-elem bg-theme--gallery">
                <div class="item-detail-spacer--bottom text-color--blaze-orange text-size--upper-medium">Playstation 4</div>

                <div class="item-detail-info">
                    <h3 class="item-detail__title item-detail__title--main">{{ title }}</h3>
                    <span class="item-detail-info__price">1500&#x20bd;</span>
                </div>
            </div>

            <div class="item-detail-elem item-detail__more">
                <div class="item-detail__description">
                    <h4 class="item-detail__title item-detail-spacer--bottom">Описание:</h4>
                    <p>Ну ебать наигрался уже, коробку говном собака измазала, скидка 10% или больше, мне похуй.</p>
                </div>
                <div class="poster">
                    <div class="poster__img bg-theme--gallery"></div>
                    <carousel class="poster__slider item-detail-spacer--top">
                        <slide class="poster__img--sm poster__slider-item bg-theme--gallery"></slide>
                        <slide class="poster__img--sm poster__slider-item bg-theme--gallery"></slide>
                        <slide class="poster__img--sm poster__slider-item bg-theme--gallery"></slide>
                        <slide class="poster__img--sm poster__slider-item bg-theme--gallery"></slide>
                    </carousel>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import Vue from 'vue';
    import { Carousel, Slide } from 'vue-carousel';

    export default Vue.extend({
        name: 'MarketItemDetail',

        data() {
            return {
               title: this.$route.params.detailData['name'],
            };
        },

        created(): void {
            this.$emit('item-detail-view-create');
        },

        destroyed(): void {
            this.$emit('item-detail-view-destroy');
        },

        components: {
            Carousel,
            Slide,
        },
    });
</script>

<style lang="styl" type="text/stylus">
    @require "../../../styl/_mixins";

    .item-detail-wrapper
        &__content
            padding-right: 32px

    .item-detail-elem
        padding: 20px

    .item-detail-top
        display: flex
        flex-flow: column nowrap

    .item-detail-spacer--bottom
            margin-bottom: 6px

    .item-detail
        font-size: 18px
        font-family: RobotoRegular

        &__more
            display: flex
            justify-content: space-between
            align-items: flex-start
            padding-right: 0

        &__description
            font-size: 16px

        &__title
            display: inline-block
            font-family: Roboto
            font-size: 18px

            &--main
                font-size: 24px

    .item-detail-info
        font-family: Roboto
        font-size: 24px
        line-height: 1.16

        &__edition
            font-size: 18px

        &__price
            float: right

    .poster
        max-width: 280px

        &__img
            width: 100%
            min-height: 190px

            &--sm
                size(72px)

        &__slider
            margin-top: 12px

        &__slider-item:not(:last-child)
            margin-right: 12px


    .VueCarousel-inner
        flex-basis: 72px !important
</style>
