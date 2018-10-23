import Vue from 'vue';
import VueRouter from 'vue-router';

// @ts-ignore
import MarketList from '../vue/components/market/MarketList.vue';
// @ts-ignore
import MarketItemDetail from '../vue/components/market/MarketItemDetail.vue';

const routes = [
    {
        path: '/',
        component: MarketList,
    },
    {
        path: '/item',
        component: MarketItemDetail,
    }
];

const router = new VueRouter({
    mode: 'history',
    routes, // сокращённая запись для `routes: routes`
});

Vue.use(VueRouter);

export default router;
