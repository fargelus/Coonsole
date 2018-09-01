<template>
  <div id="app" class="app top-line--flamingo">
    <Header/>
    <HeaderFilter/>
    <router-view></router-view>
  </div>
</template>

<script>
  import Header from './components/Header.vue';
  import HeaderFilter from './components/HeaderFilter.vue';

  export default {
    components: {
      Header,
      HeaderFilter,
    },
  }
</script>

<style lang="styl" scoped>
  @require '../styl/_variables.styl'

  .app
    margin: 0 auto
    padding-top: 12px

</style>
