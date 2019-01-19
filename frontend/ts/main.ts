import Vue from 'vue';

import router from './router';
import App from '../vue/App.vue';
import '../styl/all.styl';
import './ui/ui-btn';
import './ui/icons';

new Vue({
    el: '#app',
    router,
    components: {App},
});

import './ui/images';
