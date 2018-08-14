<template>
  <div id="wrapper">
    <div id="app">
      <Header/>
      <HeaderFilter/>

    </div>
  </div>
</template>

<style>
  #wrapper {
    border-top: 5px solid #EC5A24;
    width: 100%;
    padding: 8px 0;
  }

  #app {
    margin: 0 auto;
    padding: 0;
  }

  .top_line {
    width: 100%;
    height: 4px;
  }
</style>

<script>
  import Header from './components/header.vue';
  import HeaderFilter from './components/HeaderFilter.vue';

  export default {

    components: {
      Header,
      HeaderFilter
    },

  }
</script>
