window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.axios.defaults.withCredentials = true;

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

 Vue.component('Backend', require('./components/backend/Base.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
//Vuex
import store from './vuex/store';

import router from './router/routes';

import * as ModalDialogs from 'vue-modal-dialogs'

// Install vue-modal-dialogs
Vue.use(ModalDialogs)

import TmcSnitch from 'tmc-snitch';

Vue.use(TmcSnitch, {
    globalDebug: true,
    debugGroups: [],
});

import Tabs from './plugins/tabs/src/index';

Vue.use(Tabs);

const app = new Vue({
    el: '#app',
    store,
    router,
    created() {
         store.dispatch('auth/me').then((resp) => {
            const user = resp;
            store.dispatch('company/getCompany', user.company_id)
        })
    }

});
