<template>
  <div id="wrapper" class="app-wrapper">
    <div id="app" class="app">
      <Header/>
      <HeaderFilter/>
      <router-view></router-view>
      <Modal/>
    </div>
  </div>
</template>

<style lang="styl" scoped>
  @require '../styl/_variables.styl'

  .app-wrapper
    border-top: 5px solid $flamingo
    width: 100%
    padding: 8px 0

  .app
    margin: 0 auto
    padding: 0

  .top_line
    width: 100%
    height: 4px
</style>

<script>
  import Header from './components/Header.vue';
  import HeaderFilter from './components/HeaderFilter.vue';
  import Modal from './components/Modal.vue';

  export default {

    components: {
      Header,
      HeaderFilter,
      Modal
    },

  }
</script>
