import { createRouter, createWebHistory } from 'vue-router'

import LandingPageTemplate from '../components/LandingPageTemplate'
import HomeTemplate from '../components/HomeTemplate'
import CreateIngrediente from '../components/ingrediente/CreateIngrediente'
import UpdateIngrediente from '../components/ingrediente/UpdateIngrediente'
import ChangeIngredientInfo from '../components/ingrediente/ChangeIngredientInfo'
import ChooseBottleSize from '../components/steps/Step1ChooseBottleSize'
import step2Component  from '../components/steps/Step2ChooseIngediente'
import ShopComponent  from '../components/steps/ShopComponent'
import Step3ChooseLiquid  from '../components/steps/Step3ChooseLiquid'
import LoginComponent  from '../components/auth/LoginComponent'
import RegisterComponent  from '../components/auth/RegisterComponent'

const routes = [
    {
        path: '/',
        name: 'LandingPageTemplate',
        component: LandingPageTemplate
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
        component: ShopComponent
    },
    {
        path: '/home',
        name: 'home',
        component: HomeTemplate
    },
    {
        path: '/create',
        name: 'create',
        component: CreateIngrediente
    },
    {
        path: '/update/IngredientList/:id',
        name: 'IngredientList',
        component: ChangeIngredientInfo,
        props: true
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