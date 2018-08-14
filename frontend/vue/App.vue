<template>
  <div id="wrapper">
    <div id="app">
      <Header/>
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
    max-width: 940px;
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

  export default {
    components: {
      Header
    }
  }
</script>
