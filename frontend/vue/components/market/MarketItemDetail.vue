<template>
    <div class="item-detail-wrapper bg-theme--snow">
        <div class="item-detail item-detail-wrapper__content">
            <div class="item-detail__title bg-theme--gallery">
                <div class="item-detail__type text-color--blaze-orange text-size--upper-medium">Playstation 4</div>
                <div class="item-detail__name">The Elder Scrolls III: Morrowind.
                    Game of the Year Edition
                </div>
                <div class="item-detail__price">1500&#x20bd;</div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import Vue from 'vue';

    export default Vue.extend({
        name: 'MarketItemDetail',

        created(): void {
            this.$emit('item-detail-view-create');
        },

        destroyed(): void {
            this.$emit('item-detail-view-destroy');
        }
    });
</script>

<style lang="styl" type="text/stylus">
    .item-detail-wrapper
        &__content
            padding-right: 32px

    .item-detail
        &__title
            display: flex
            flex-flow: column nowrap
            padding: 20px

        &__type
            margin-bottom: 8px
</style>
