import Vue from 'vue';
import App from './vue/App.vue';
import '../styles/all.css';

const vm = new Vue({
  el: '#app',
  data: {
    message: 'test',
  },

  render: h => h(App),
});
