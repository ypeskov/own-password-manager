/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
window.Vue = Vue;

import Vue2Filters from 'vue2-filters';
Vue.use(Vue2Filters);


/**
 * Add support of i18n
 *
 * @param string
 * @param args
 * @returns {*}
 */
Vue.prototype.trans = (string, args) => {

    let value = _.get(window.i18n, string);

    _.eachRight(args, (paramVal, paramKey) => {
        value = _.replace(value, `:${paramKey}`, paramVal);
    });

    return value;
};

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// Vue.component('select-new-item', require('./components/SelectNewItem.vue').default);
// Vue.component('delete-item', require('./components/DeleteItem.vue').default);
// Vue.component('items-container', require('./components/ItemsContainer.vue').default);
// Vue.component('header-navigation', require('./components/HeaderNavigation.vue').default);
// Vue.component('change-user-property', require('./components/ChangeUserPropertyComponent').default);
// Vue.component('change-password', require('./components/ChangePasswordComponent').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
