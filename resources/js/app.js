/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import VueAxios from 'vue-axios';
import axios from 'axios';

import AppUser from './App.vue';
Vue.use(VueAxios, axios);

import HomeComponent from './components/users/HomeComponent';
import CreateUserComponent from './components/users/CreateUserComponent';
import IndexUserComponent from './components/users/IndexUserComponent';
import EditUserComponent from './components/users/EditUserComponent';
import LoginUserComponent from  './components/users/LoginUserComponent';

const routes = [
        {
            name: 'login',
            path: '/login',
            component: LoginUserComponent,
        },
        {
            name: 'home',
            path: '/',
            component: HomeComponent,
        },
        {
            name: 'create',
            path: '/create',
            component: CreateUserComponent,
        },
        {
            name: 'users',
            path: '/users',
            component: IndexUserComponent,
        },
        {
            name: 'edit',
            path: '/edit/:id',
            component: EditUserComponent,
        },
];


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/*Vue.component('example-component', require('./components/ExampleComponent.vue').default);*/

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

    const router = new VueRouter({ mode: 'history', routes: routes});
    const app = new Vue(Vue.util.extend({ router }, AppUser)).$mount('#app');
/**const app = new Vue({
    el: '#app'
});*/
