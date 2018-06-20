import Vue from 'vue';
import App from './vue/App.vue';

const vm = new Vue({
  el: '#app',
  data: {
    message: 'test',
  },

  render: h => h(App),
});
