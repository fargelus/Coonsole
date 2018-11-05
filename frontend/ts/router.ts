import Vue from 'vue';
import VueRouter from 'vue-router';

import MarketList from '../vue/components/market/MarketList.vue';
import MarketItemDetail from '../vue/components/market/MarketItemDetail.vue';

const routes = [
    {
        path: '/',
        component: MarketList,
    },
    {
        name: 'MarketItemDetail',
        path: '/item/:link',
        component: MarketItemDetail,
        props: true,
    }
];

const router = new VueRouter({
    mode: 'history',
    routes, // сокращённая запись для `routes: routes`
});

Vue.use(VueRouter);

export default router;
