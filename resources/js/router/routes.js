import Vue from 'vue';
import VueRouter from 'vue-router'

import Base from '../components/backend/Base'
import Dashboard from '../components/backend/dashboard/Dashboard'

Vue.use(VueRouter);

const routes = [
    { path: '/', component: Base, name: 'Base', redirect: { name: 'Dashboard' } , children: [
        { path: '/dashboard', component: Dashboard, name: 'Dashboard'},
    ]},
];

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes,
});


export default router
