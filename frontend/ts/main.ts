import Vue from 'vue';

import router from './router';
import App from '../vue/App.vue';
import '../styl/all.styl';
import '../ts/ui';
import './icons';

new Vue({
    router,
    render: h => h(App),
}).$mount('#app');

import './images';
