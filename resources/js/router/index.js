import { createRouter, createWebHistory } from 'vue-router'

/* Component import area */
import LandingPageTemplate from '../components/LandingPageTemplate'
import CreateIngredient from '../components/ingredient/CreateIngredient'
import UpdateIngredient from '../components/ingredient/UpdateIngredient'
import ChangeIngredientInfo from '../components/ingredient/ChangeIngredientInfo'
import CreateIngredientInfo from '../components/ingredient/CreateIngredientInfo'
import ChooseBottleSize from '../components/steps/Step1ChooseBottleSize'
import step2Component  from '../components/steps/Step2ChooseIngedient'
import ShopComponent  from '../components/steps/ShopComponent'
import Step3ChooseLiquid  from '../components/steps/Step3ChooseLiquid'
import LoginComponent  from '../components/auth/LoginComponent'
import CustomerTemplate  from '../components/auth/CustomerTemplate'
import EmployeeTemplate from '../components/auth/EmployeeTemplate'
import RegisterComponent  from '../components/auth/RegisterComponent'

// All Vue routes
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
        path: '/chooseIngredient',
        name: 'chooseIngredient',
        component: step2Component
    },
    {
        path: '/chooseLiquid',
        name: 'chooseLiquid',
        component: Step3ChooseLiquid
    },
    {
        path: '/shop',
        name: 'shop',
        component: ShopComponent
    },
    {
        path: '/employeeTemplate',
        name: 'employeeTemplate',
        component: EmployeeTemplate
    },
    {
        path: '/customerTemplate',
        name: 'customerTemplate',
        component: CustomerTemplate
    },
    {
        path: '/create',
        name: 'create',
        component: CreateIngredient
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
        path: "/update/ingredient/:id",
        name: "update-ingredient",
        component: UpdateIngredient,
        props: true 
    },
    {
        path: "/create/IngredientInfo/:id",
        name: "update-ingredientInfo",
        component: CreateIngredientInfo,
        props: true 
    }
];

export default createRouter({
    history: createWebHistory(),
    routes
})