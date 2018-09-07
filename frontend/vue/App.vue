<template>
  <div id="app" class="app top-line--flamingo">
    <div class="main-content">
      <Header v-on:city-button-click="showCitiesListModal"/>
      <HeaderFilter/>
    </div>

    <CitiesListModal v-if="isCitiesModalListOpen" v-click-outside="hideCitiesListModal"/>
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
        console.dir(res);
      });
    },

    methods: {
      showCitiesListModal() {
        this.isCitiesModalListOpen = true;
        $('.main-content').addClass('blured');
      },

      hideCitiesListModal() {
        this.isCitiesModalListOpen = false;
        $('.main-content').removeClass('blured');
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
