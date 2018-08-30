import Vue from 'vue';
import VueRouter from 'vue-router';

import App from '../vue/App.vue';
import MarketList from '../vue/components/market/MarketList.vue';
import Modal from '../vue/components/Modal.vue';


const routes = [
    {
        path: '/',
        component: MarketList,
        /*children: [
            {
                path: '',
                component: MarketList,
            },
        ],*/
        /*beforeEnter: (to, from, next) => {
            console.log('SMS list beforeEnter()');
            next();
        }*/
    },
    { path: '/bar', component: Modal },
];

const router = new VueRouter({
    mode: 'history',
    routes, // сокращённая запись для `routes: routes`
});

Vue.use(VueRouter);

export default router;
