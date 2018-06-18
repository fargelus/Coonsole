import Vue from 'vue';
import App from './vue/App.vue';

const vm = new Vue({
  el: '#app',
  render: h => h(App),
});
