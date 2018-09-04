<template>
  <div id="app" class="app top-line--flamingo">
    <div class="main-content">
      <Header v-on:city-button-click="toggleCitiesListModal"/>
      <HeaderFilter/>
    </div>

    <CitiesListModal ref="citiesModal"/>
    <router-view></router-view>
  </div>
</template>

<script>
  import $ from 'jquery';
  import Header from './components/Header.vue';
  import HeaderFilter from './components/HeaderFilter.vue';
  import CitiesListModal from './components/CitiesListModal.vue';

  export default {
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
      toggleCitiesListModal() {
        const citiesModalHTML = this.$refs.citiesModal.$el;
        $(citiesModalHTML).toggle();
        $('.main-content').toggleClass('blured');
      }
    }
  }
</script>

<style lang="styl" scoped>
  @require '../styl/_variables.styl'

  .app
    margin: 0 auto
    padding-top: 12px
    height: 100%

</style>
