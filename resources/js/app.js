/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/* integrate vue and vuetify */
import { createApp } from 'vue'
import AppView from './components/App'
import { createVuetify  } from 'vuetify'
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import router from './router'
import axios from 'axios';

const vuetify = createVuetify({ components, directives});

const app = createApp()
app.config.globalProperties.$http = axios;
app.component('app-view', AppView)
app.use(vuetify)
app.use(router)
app.mount('#app')


