import { createRouter, createWebHistory } from 'vue-router'

import WelcomeComponent from '../components/WelcomeComponent'
import ChooseBottleSize from '../components/steps/Step1ChooseBottleSize'
import step2Component  from '../components/steps/Step2ChooseIngediente'
import step3Component  from '../components/steps/Step3ShopComponent'

const routes = [
    {
        path: '/',
        name: 'welcome',
        component: WelcomeComponent
    },
    {
        path: '/chooseBottleSize',
        name: 'chooseBottleSize',
        component: ChooseBottleSize
    },
    {
        path: '/chooseIngrediente',
        name: 'step2',
        component: step2Component
    },
    {
        path: '/shop',
        name: 'step3',
        component: step3Component
    }
];

export default createRouter({
    history: createWebHistory(),
    routes
})