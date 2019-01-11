
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window.Fire = new Vue();

import Vue from 'vue'
import Vuex from 'vuex'
import VueRouter from 'vue-router';
import {routes} from './routes';
import StoreData from './store';
import { Form, HasError, AlertError } from 'vform';
import VueProgressBar from 'vue-progressbar';
import Swal from 'sweetalert2';
//moment js
import moment from 'moment';

//vueX & vueRouter
Vue.use(VueRouter);
Vue.use(Vuex)

const store = new Vuex.Store(StoreData);
//vue form
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
window.Form = Form;
//vue progressbar
Vue.use(VueProgressBar, {
    color: '#0063ae',
    failedColor: 'red',
    thickness: '5px',
})
//Sweet Alert 2
window.Swal = Swal;
const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.toast = toast;

const router = new VueRouter({
    mode: 'history', //removes # (hashtag) from url
    base: '/',
    fallback: true, //router should fallback to hash (#) mode when the browser does not support history.pushState
    routes // short for `routes: routes`
});

Vue.filter('upText', function (text) {
    return text.toUpperCase();
});

Vue.filter('myDateTimeFormat', function(created){
    return moment(created).locale('vi').format('L LT');
});

Vue.filter('myDateFormat', function(birthday){
    return moment(birthday).locale('vi').format('L'); // 01/11/2019
});

Vue.filter('myTimeDateFormat', function(updated_time){
    return moment(updated_time).locale('vi').format('LT L');//10:35 29/12/2018
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store,
    router
});
