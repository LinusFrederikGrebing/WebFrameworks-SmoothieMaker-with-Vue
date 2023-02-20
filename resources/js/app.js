/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import { createApp } from 'vue'
import ExampleComponent from './components/ExampleComponent'
import ChooseBottleSize from './components/steps/Step1ChooseBottleSize'
import FooterTemplate from './components/layouts/FooterTemplate'
import SizeComponent from './components/layouts/SizeComponent'
import MixerComponent from './components/layouts/MixerComponent'
import ProgressbarComponent from './components/layouts/ProgressbarComponent'
import step2  from './components/steps/Step2ChooseIngediente'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';

import axios from 'axios';



const vuetify = createVuetify({ components, directives });

const app = createApp({})
app.config.globalProperties.$http = axios;
app.component('welcome', ExampleComponent)
app.component('footer-template', FooterTemplate)
app.component('bottle-sizes', ChooseBottleSize)
app.component('size-component', SizeComponent)
app.component('mixer-component', MixerComponent)
app.component('progressbar-component', ProgressbarComponent)
app.component('step2', step2)
app.use(vuetify)
app.mount('#app')


