require('./bootstrap');

import { createApp } from 'vue'
import ExampleComponent from './components/ExampleComponent'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';

const vuetify = createVuetify({ components, directives });
const app = createApp({})

app.component('welcome', ExampleComponent).use(vuetify)

app.mount('#app')