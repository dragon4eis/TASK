/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// window.Vue = require('vue');

import Vue from 'vue';
import store from './store/index';
import router from './routes/index';
import {toNumber} from './helpers';
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
//
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.filter('prettyTimestamp', function (ts, format = 'YYYY-MM-DD HH:mm:ss') {
    if (typeof ts !== 'number') {
        ts = toNumber(ts)
    }
    if (typeof ts !== 'number' || isNaN(ts)) {
        return ''
    }

    // ts = parseInt(ts).toString().length === 10 ? ts * 1000 : ts;
    // return new Date(ts).toLocaleString()

    let mts = parseInt(ts).toString().length === 10 ? moment.unix(ts) : moment(ts);
    return mts.format(format)
});

const app = new Vue({
    el: '#appContainer',
    router,
    store,
});
