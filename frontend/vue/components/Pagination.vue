<template>
    <div class="pagination bg-theme--gallery">
        <div class="pagination__item pagination-item"
             :class="{
                'pagination__item--active': n === 1,
            }" v-for="n in 3">{{n}}</div>
    </div>
</template>

<script>
    export default {
        name: "Pagination"
    }
</script>

<style lang="styl" type="text/stylus">
    @require '../../styl/_variables.styl'
    @require '../../styl/_mixins.styl'
    @require "../../styl/modificators/_modifators"

    .pagination
        display: flex
        justify-content: center
        position: absolute
        align-items: center
        left: 0
        top: 0
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
