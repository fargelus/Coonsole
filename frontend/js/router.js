import Vue from 'vue';
import VueRouter from 'vue-router';

import App from '../vue/App.vue';

const routes = [
    { path: '/', component: App },
    //{ path: '/bar', component: Bar },
];

const router = new VueRouter({
    routes, // сокращённая запись для `routes: routes`
});

export default router;
