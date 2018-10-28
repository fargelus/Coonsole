<template>
    <aside class="aside page-content__aside">
        <Filters v-show="!isHideFilters"></Filters>
        <button class="button transparent aside__back-btn"
                v-show="isHideFilters"
                @click="onBackBtnClick">
            <div>
                <img src="" class="js-arrow-left button__label-left" alt="Вернуться назад" width="17" height="18">
                Вернуться назад
            </div>
        </button>
    </aside>
</template>

<script lang="ts">
    import Vue from 'vue';
    import Filters from './Filters.vue';

    export default Vue.extend({
        name: 'Aside',

        data(): object {
            return {
                isHideFilters: false,
            }
        },

        props: {
            changeView: {
                type: Boolean,
                default: false
            }
        },

        methods: {
            onBackBtnClick(): void {
                this['isHideFilters'] = false;
                history.back();
            },
        },

        watch: {
            changeView(hideFiltersFlag: boolean): void {
                this['isHideFilters'] = hideFiltersFlag;
            }
        },

        components: {
            Filters,
        }
    });
</script>

<style lang="styl" type="text/stylus">
    @require '../../styl/_variables';

    .aside
        &__back-btn
            display: flex
            flex-direction: column
            width: 100%

            &.button
                padding-top: 22px
                max-width: unset
                font-size: 18px
                line-height: 1.16
                font-family: Roboto

            &:hover
                background-color: $gallery-dark

</style>
