<template>
  <div id="app" class="app">
    <div class="page-content top-line--flamingo" :class="{blured: isCitiesModalListOpen}">
      <header>
        <Top :location="currentUserLocation" v-on:city-button-click="showCitiesListModal"/>
        <HeaderFilter v-if="false"/>
      </header>

      <main>
        <aside class="page-content__aside">
          <Filters/>
        </aside>

        <MarketList class="page-content__market border-theme--gallery"/>
      </main>
    </div>

    <CitiesListModal v-on:city-changed="setNewUserLocation" :citiesListProp="getCitiesModalData" v-if="isCitiesModalListOpen" v-click-outside="hideCitiesListModal"/>
    <router-view v-if="false"></router-view>
  </div>
</template>

<script>
  import $ from 'jquery';
  import ClickOutside from 'vue-click-outside';
  import Top from './components/Top.vue';
  import HeaderFilter from './components/HeaderFilter.vue';
  import CitiesListModal from './components/CitiesListModal.vue';
  import Filters from './components/Filters.vue';
  import MarketList from './components/market/MarketList.vue';

  export default {
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
      const that = this;
      $.getJSON('./data/cities.json', (res) => {
        that.citiesModalData = res;
      });
    },

    computed: {
      // Когда компонент модалки отрисовывается
      // мы можем еще не получить данные с сервера
      // поэтому такой вот хак(
      getCitiesModalData() {
        return this.citiesModalData ? this.citiesModalData : [];
      }
    },

    methods: {
      showCitiesListModal() {
        this.isCitiesModalListOpen = true;
      },

      hideCitiesListModal() {
        this.isCitiesModalListOpen = false;
      },

      /**
       * Передает выбранный пользователем город в дочерний компонент Header.
       *
       * @param {String} choosedCityName - Название города возвращенного из модалки.
       */
      setNewUserLocation(choosedCityName) {
        this.hideCitiesListModal();
        this.currentUserLocation = choosedCityName;
      }
    },

    directives: {
      ClickOutside,
    }
  }
</script>

<style lang="styl" scoped>
  @require '../styl/_variables.styl'

  .app
    margin: 0 auto
    height: 100%
    max-width: 1152px

  .page-content
    &__aside
      min-width: 232px
      float: left
      clear: both

    &__market
      margin-left: 232px
      padding: 0 0 15px 32px
      min-height: 100%
      border-right: 0
      border-left: 0
</style>
