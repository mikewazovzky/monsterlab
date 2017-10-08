
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
window.Vue = Vue;

// create global event bus
window.events = new Vue();

// create global flash function
window.flash = function (message, level = 'success') {
    window.events.$emit('flash', { message, level });
};

Vue.component('flash', require('./components/Flash.vue'));

const app = new Vue({
    el: '#app'
});
