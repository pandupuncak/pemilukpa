require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter)

import { InertiaApp } from '@inertiajs/inertia-vue';
import { InertiaForm } from 'laravel-jetstream';
import PortalVue from 'portal-vue';
import VueConfirmDialog from 'vue-confirm-dialog';

Vue.mixin({ methods: { route } });
Vue.use(InertiaApp);
Vue.use(InertiaForm);
Vue.use(PortalVue);
Vue.use(VueConfirmDialog);
Vue.component('vue-confirm-dialog', VueConfirmDialog.default);

import App from './Pages/App'
import Dashboard from './Pages/Dashboard'
import Requests from './Pages/Requests'
import Results from './Pages/Results'
import Users from './Pages/User'
import Voting from './Pages/Voting'
import Voters from './Pages/Voters'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'Dashboard',
            component: Dashboard
        },
        {
            path: '/users',
            name: 'Users',
            component: Users
        },
        {
            path: '/vote',
            name: 'Vote',
            component: Voting
        },
        {
            path: '/vote/voters',
            name: 'Voters',
            component: Voters
        },
        {
            path: '/vote/requests',
            name: 'VoteRequests',
            component: Requests
        },
        {
            path: '/vote/results',
            name: 'VoteResult',
            component: Results
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});

// const app = document.getElementById('app');

// new Vue({
//     render: (h) =>
//         h(InertiaApp, {
//             props: {
//                 initialPage: JSON.parse(app.dataset.page),
//                 resolveComponent: (name) => require(`./Pages/${name}`).default,
//             },
//         }),
// }).$mount(app);
