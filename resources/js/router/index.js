import { createRouter, createWebHistory } from 'vue-router'

import WelcomeComponent from '../components/WelcomeComponent'
import HomeComponent from '../components/HomeComponent'
import CreateIngrediente from '../components/ingrediente/createIngrediente'
import UpdateIngrediente from '../components/ingrediente/updateIngrediente'
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
    },
    {
        path: '/home',
        name: 'home',
        component: HomeComponent
    },
    {
        path: '/create',
        name: 'create',
        component: CreateIngrediente
    },
    {
        path: "/update/ingrediente/:id",
        name: "update-ingrediente",
        component: UpdateIngrediente,
        props: true // Prop durch Route übergeben
    }
];

export default createRouter({
    history: createWebHistory(),
    routes
})