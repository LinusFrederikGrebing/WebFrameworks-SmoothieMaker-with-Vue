/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import { createApp } from 'vue'
import ExampleComponent from './components/ExampleComponent'
import ChooseBottleSize from './components/ChooseBottleSize'
import FooterTemplate from './components/FooterTemplate'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';

const vuetify = createVuetify({ components, directives });

const app = createApp({})
app.component('welcome', ExampleComponent)
app.component('footer-template', FooterTemplate)
app.component('bottle-sizes', ChooseBottleSize)
app.use(vuetify)
app.mount('#app')


