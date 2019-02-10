<template>
    <div class="pagination bg-theme--gallery">
        <div class="pagination__item pagination-item"
             @click="turnOverPage(page)"
             :class="{
                'pagination__item--active': page === currentPage,
            }" v-for="page in pages">{{page}}</div>
    </div>
</template>

<script lang="ts">
    import Vue from 'vue';

    export default Vue.extend({
        name: "Pagination",

        props: {
            pages: {
                type: Number,
                default: 0,
            },
        },

        data() {
            return {
                currentPage: 1,
            }
        },

        methods: {
            turnOverPage(newPage: number): void {
                this.currentPage = newPage;
                this.$emit('switch-page', newPage);
            }
        },
    });
</script>

<style lang="styl" type="text/stylus">
    @require '../../styl/_variables.styl'
    @require '../../styl/_mixins.styl'
    @require "../../styl/modificators/_modifators"

    .pagination
        display: flex
        justify-content: center
        align-items: center
        height: 32px
        width: 100%

        &__item
            text-align: center
            margin-right: 3px
            cursor: pointer
            height: 34px
            width: 34px
            line-height: 32px
            border-top: 1px solid transparent
            border-top-left-radius: 6px
            border-top-right-radius: 6px

            &--active
                background-color: $snow
                color: $blaze-orange
                border-color: $snow
                pseudo()

                &::after
                    top: auto
                    bottom: 0
                    width: 100%
                    height: 4px
                    background-color: $blaze-orange
                    box-shadow: 0 0 6px $blaze-orange

            &:hover:not(.pagination__item--active)
                @extend .bg-theme--white-orange
</style>
