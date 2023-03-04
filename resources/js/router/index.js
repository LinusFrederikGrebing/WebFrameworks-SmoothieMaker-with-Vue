import { createRouter, createWebHistory } from 'vue-router'

import WelcomeComponent from '../components/WelcomeComponent'
import HomeComponent from '../components/HomeComponent'
import CreateIngrediente from '../components/ingrediente/createIngrediente'
import UpdateIngrediente from '../components/ingrediente/updateIngrediente'
import ChooseBottleSize from '../components/steps/Step1ChooseBottleSize'
import step2Component  from '../components/steps/Step2ChooseIngediente'
import step3Component  from '../components/steps/Step3ShopComponent'
import Step3ChooseLiquid  from '../components/steps/Step3ChooseLiquid'
import LoginComponent  from '../components/auth/LoginComponent'
import RegisterComponent  from '../components/auth/RegisterComponent'

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
        path: '/chooseLiquid',
        name: 'step3',
        component: Step3ChooseLiquid
    },
    {
        path: '/shop',
        name: 'shop',
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
        path: '/login',
        name: 'login',
        component: LoginComponent
    },
    {
        path: '/register',
        name: 'register',
        component: RegisterComponent
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