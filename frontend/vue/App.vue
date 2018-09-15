<template>
  <div id="app" class="app top-line--flamingo">
    <div class="main-content" :class="{blured: isCitiesModalListOpen}">
      <Header :location="currentUserLocation" v-on:city-button-click="showCitiesListModal"/>
      <HeaderFilter v-if="false"/>
      
      <aside>
        <Filters/>
      </aside>
    </div>

    <CitiesListModal v-on:city-changed="setNewUserLocation" :citiesListProp="getCitiesModalData" v-if="isCitiesModalListOpen" v-click-outside="hideCitiesListModal"/>
    <router-view v-if="false"></router-view>
  </div>
</template>

<script>
  import $ from 'jquery';
  import ClickOutside from 'vue-click-outside';
  import Header from './components/Header.vue';
  import HeaderFilter from './components/HeaderFilter.vue';
  import CitiesListModal from './components/CitiesListModal.vue';
  import Filters from './components/Filters.vue';

  export default {
    data() {
      return {
        isCitiesModalListOpen: false,
        citiesModalData: [],
        currentUserLocation: ''
      }
    },

    components: {
      Header,
      HeaderFilter,
      CitiesListModal,
      Filters
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

</style>
