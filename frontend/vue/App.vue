<template>
    <div id="app" class="app">
        <div class="overlay"
             :class="{
                'overlay--visible': isModalOpen,
            }"></div>

        <div class="page-content top-line--flamingo"
             :class="{'blured': isModalOpen}">
            <header class="page-content__header bg-theme--snow">
                <Top class="page-content__header-top"
                     :outerLocation="currentUserLocation"
                     @city-button="showModal('city')"
                     @entrance-button="showModal('entrance')"></Top>
            </header>

            <main class="main page-content__main">
                <Aside :changeView="isChangeAsideView" class="page-content__aside"></Aside>
                <router-view
                    @item-detail-view-create="toggleAsideViewChange"
                    @item-detail-view-destroy="toggleAsideViewChange"
                    class="page-content__market"></router-view>
            </main>
        </div>

        <CitiesListModal
            @city-changed="setNewUserLocation"
            :citiesListProp="getCitiesModalData"
            v-if="modals.city"
            v-click-outside="hideVisibleModal"></CitiesListModal>
        <EntranceModal
            v-if="modals.entrance"
            v-click-outside="hideVisibleModal"></EntranceModal>
    </div>
</template>

<script lang="ts">
    import Vue from 'vue';
    import axios from 'axios';
    import ClickOutside from 'vue-click-outside';
    import * as _ from 'underscore';

    import './components/Helpers.vue';

    import Top from './components/Top.vue';
    import Aside from './components/Aside.vue';
    import MarketList from './components/market/MarketList.vue';

    import CitiesListModal from './components/modals/CitiesListModal.vue';
    import EntranceModal from './components/modals/entrance_modal/EntranceModal.vue';

    export default Vue.extend({
        data() {
            return {
                citiesModalData: [],
                currentUserLocation: '',
                isChangeAsideView: false,
                isModalOpen: false,
                modals: { city: false, entrance: false }
            }
        },

        components: {
            Top,
            Aside,
            MarketList,
            CitiesListModal,
            EntranceModal,
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
            showModal(type: string) {
                this.modals[type] = true;
                document.body.classList.add('ov-hidden');
                this.isModalOpen = true;
            },

            hideVisibleModal() {
                const type: string = _.keys(this.modals)
                                      .filter((key) => this.modals[key])[0] as string;

                this.modals[type] = false;
                document.body.classList.remove('ov-hidden');
                this.isModalOpen = false;
            },

            /**
             * Передает выбранный пользователем город в дочерний компонент Header.
             *
             * @param {String} choosedCityName - Название города возвращенного из модалки.
             */
            setNewUserLocation(choosedCityName: string) {
                this.hideVisibleModal();
                this.currentUserLocation = choosedCityName;
            },

            toggleAsideViewChange(): void {
                this.isChangeAsideView = !this.isChangeAsideView;
            },
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
            left: 0
            top: 0
            width: 100%

        &__main
            padding-top: 71px
            border-top: 1px solid $chicago-transp

        &__aside
            min-width: 232px
            float: left
            clear: both

        &__market
            margin-left: 232px
            padding: 62px 0 15px 26px
            min-height: 100%
</style>
