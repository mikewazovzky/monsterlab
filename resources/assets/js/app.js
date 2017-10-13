
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

// set up auth as a s single point to manage authorizations for frontend
const authorizations = require('./authorizations');

Vue.prototype.authorize = function (...params) {
    if (!window.App.user) return false;

    if(window.App.user.role === 'admin') return true;

    if (typeof params[0] === 'string') {
        return authorizations[params[0]](params[1]);
    }

    return params[0](window.App.user);
};

Vue.prototype.signedIn = window.App.signedIn;

// create global flash function
window.flash = function (message, level = 'success') {
    window.events.$emit('flash', { message, level });
};

Vue.component('flash', require('./components/Flash.vue'));
Vue.component('paginator', require('./components/Paginator.vue'));
Vue.component('replies', require('./components/Replies.vue'));
Vue.component('avatar-form', require('./components/AvatarForm.vue'));
Vue.component('carousel', require('./components/Carousel.vue'));
Vue.component('main-menu', require('./components/MainMenu.vue'));

const app = new Vue({
    el: '#app'
});
