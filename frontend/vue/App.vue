<template>
  <div id="app" class="app top-line--flamingo">
    <div class="main-content" :class="{blured: isCitiesModalListOpen}">
      <Header :location="currentUserLocation" v-on:city-button-click="showCitiesListModal"/>
      <HeaderFilter/>
    </div>

    <CitiesListModal v-on:city-changed="setNewUserLocation" :citiesListProp="getCitiesModalData" v-if="isCitiesModalListOpen" v-click-outside="hideCitiesListModal"/>
    <router-view></router-view>
  </div>
</template>

<script>
  import $ from 'jquery';
  import ClickOutside from 'vue-click-outside';
  import Header from './components/Header.vue';
  import HeaderFilter from './components/HeaderFilter.vue';
  import CitiesListModal from './components/CitiesListModal.vue';

  export default {
    data() {
      return {
        isCitiesModalListOpen: false,
        citiesModalData: [],
        currentUserLocation: 'Санкт-Петербург'
      }
    },

    components: {
      Header,
      HeaderFilter,
      CitiesListModal,
    },

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

</style>
