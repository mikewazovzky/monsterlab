
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
window.Vue = Vue;

import moment from 'moment';
window.moment = moment;

// create global event bus
window.events = new Vue();

// create global flash function
window.flash = function (message, level = 'success') {
    window.events.$emit('flash', { message, level });
};

Vue.component('flash', require('./components/Flash.vue'));
Vue.component('paginator', require('./components/Paginator.vue'));
Vue.component('replies', require('./components/Replies.vue'));

const app = new Vue({
    el: '#app'
});
