
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import App from './components/App';
import Playlists from './components/Playlists';
import Playlist from './components/Playlist';

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'playlists',
            component: Playlists,
        },
        
        {
            path: '/playlist/:playlistId',
            name: 'playlist',
            component: Playlist,
        },

    ]
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: { App, Playlists },
    router,
});
