require('./bootstrap');

import Vue from 'vue';
window.Vue = Vue;

import InstantSearch from 'vue-instantsearch';
Vue.use(InstantSearch);

import moment from 'moment';
window.moment = moment;

// create global event bus
window.events = new Vue();

// set up auth as a s single point to manage authorizations for frontend
const authorizations = require('./authorizations');

Vue.prototype.authorize = function (...params) {
    if (!window.App.user) return false;

    if (window.App.user.role === 'admin') return true;

    if (typeof params[0] === 'string') {
        return authorizations[params[0]](params[1]);
    }

    return params[0](window.App.user);
};

Vue.prototype.signedIn = window.App.signedIn;
Vue.prototype.signedUser = window.App.user;

Vue.prototype.isAdmin = function () {
    return window.App.user.role === 'admin';
};

// create global flash function
window.flash = function (message, level = 'success') {
    window.events.$emit('flash', { message, level });
};

Vue.component('flash', require('./components/Flash.vue'));
Vue.component('tags', require('./components/Tags.vue'));
Vue.component('paginator', require('./components/Paginator.vue'));
Vue.component('replies', require('./components/Replies.vue'));
Vue.component('carousel', require('./components/Carousel.vue'));
Vue.component('main-menu', require('./components/MainMenu.vue'));
Vue.component('avatar-form', require('./components/AvatarForm.vue'));
Vue.component('user-data', require('./components/UserData.vue'));
Vue.component('user-data-role', require('./components/UserDataRole.vue'));
Vue.component('user-data-password', require('./components/UserDataPassword.vue'));
Vue.component('notifications', require('./components/Notifications.vue'));
Vue.component('notifications-count', require('./components/NotificationsCount.vue'));
Vue.component('search', require('./components/Search.vue'));
Vue.component('list-item', require('./components/ListItem.vue'));
Vue.component('list-group', require('./components/ListGroup.vue'));
Vue.component('featured-image', require('./components/FeaturedImage.vue'));

Vue.component('favorite', require('./components/favoritable/Favorite.vue'));
Vue.component('favorite-vidget', require('./components/favoritable/FavoriteVidget.vue'));

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

const app = new Vue({
    el: '#app'
});
