
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');

window.Vue = require('vue');

window.Fire = new Vue();

import Swal from 'sweetalert2';
window.Swal = Swal;
const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.toast = toast;

import VueProgressBar from 'vue-progressbar';
Vue.use(VueProgressBar, {
    color: '#0063ae',
    failedColor: 'red',
    thickness: '5px',
})

import moment from 'moment';

import axios from 'axios';
window.axios = axios;

import { Form, HasError, AlertError } from 'vform';
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
window.Form = Form;

import VueRouter from 'vue-router';
Vue.use(VueRouter);

let routes = [
    { path: '/', component: require('./components/Dashboard.vue').default },
    { path: '/faculties-admin', component: require('./components/FacultiesAdmin.vue').default },
    { path: '/faculties', component: require('./components/FacultiesClient.vue').default },
    { path: '/classrooms', component: require('./components/ClassRoomsClient.vue').default },
    { path: '/students', component: require('./components/StudentsClient.vue').default },
    { path: '/student-profile', component: require('./components/StudentProfileClient.vue').default },
];

const router = new VueRouter({
    mode: 'history',
    hash: false,
    routes // short for `routes: routes`
});

Vue.filter('upText', function (text) {
    return text.toUpperCase();
});

Vue.filter('myDate', function(created){
    return moment(created).format('MMMM Do YYYY');
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
    router
});
