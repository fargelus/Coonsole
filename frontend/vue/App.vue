<template>
    <div id="app" class="app">
        <div class="page-content top-line--flamingo" :class="{blured: isCitiesModalListOpen}">
            <header class="page-content__header">
                <Top class="page-content__header-top"
                     :outerLocation="currentUserLocation"
                     @city-button-click="showCitiesListModal"/>
                <HeaderFilter v-if="false"/>
            </header>

            <main class="main page-content__main">
                <aside class="page-content__aside">
                    <Filters/>
                </aside>

                <router-view class="page-content__market"></router-view>
            </main>
        </div>

        <CitiesListModal
            @city-changed="setNewUserLocation"
            :citiesListProp="getCitiesModalData"
            v-if="isCitiesModalListOpen"
            v-click-outside="hideCitiesListModal"/>
    </div>
</template>

<script lang="ts">
    import Vue from 'vue';
    import axios from 'axios';
    import ClickOutside from 'vue-click-outside';
    import Top from './components/Top.vue';
    import HeaderFilter from './components/HeaderFilter.vue';
    import CitiesListModal from './components/CitiesListModal.vue';
    import Filters from './components/Filters.vue';
    import MarketList from './components/market/MarketList.vue';

    export default Vue.extend({
        data() {
            return {
                isCitiesModalListOpen: false,
                citiesModalData: [],
                currentUserLocation: ''
            }
        },

        components: {
            Top,
            HeaderFilter,
            CitiesListModal,
            Filters,
            MarketList
        },

        /**
         * Получает и сохраняет список городов.
         */
        beforeCreate() {
            const that: any = this;
            axios.get('./data/cities.json')
                .then((response) => that.citiesModalData = response.data);
        },

        computed: {
            // Когда компонент модалки отрисовывается
            // мы можем еще не получить данные с сервера
            // поэтому такой вот хак(
            getCitiesModalData(): string[] {
                return this.citiesModalData ? this.citiesModalData : [];
            }
        },

        methods: {
            showCitiesListModal() {
                this.isCitiesModalListOpen = true;
                document.body.classList.add('ov-hidden');
            },

            hideCitiesListModal() {
                this.isCitiesModalListOpen = false;
                document.body.classList.remove('ov-hidden');
            },

            /**
             * Передает выбранный пользователем город в дочерний компонент Header.
             *
             * @param {String} choosedCityName - Название города возвращенного из модалки.
             */
            setNewUserLocation(choosedCityName: string) {
                this.hideCitiesListModal();
                this.currentUserLocation = choosedCityName;
            }
        },

        directives: {
            ClickOutside,
        }
    });
</script>

<style lang="styl" type="text/stylus">
    @require '../styl/_variables.styl'

    /* Common Styles */
    .app, .page-content__header-top, .main
        margin: 0 auto

    .page-content__header-top, .main
        max-width: 1152px

    .page-content__header, .page-content__aside
        position: fixed
        z-index: 1

    /* End Of Common Styles */

    .app
        height: 100%

    .page-content
        &.top-line--flamingo::before
            z-index: 1000

        &__header
            background-color: $snow
            left: 0
            top: 0
            width: 100%

        &__main
            padding-top: 67px

        &__aside
            min-width: 232px
            float: left
            clear: both

        &__market
            margin-left: 232px
            padding: 0 0 15px 32px
            min-height: 100%
</style>
