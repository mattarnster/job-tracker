require('./bootstrap')

import Vue from 'vue'
import VueRouter from 'vue-router'
import { VueSpinners } from '@saeris/vue-spinners'

Vue.use(VueRouter)
Vue.use(require('vue-moment'))
Vue.use(VueSpinners)

import App from '../views/App'
import Home from '../views/Home'
import Jobs from '../views/Jobs'
import Login from '../views/Login'
import Job from '../views/Job'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/jobs',
            name: 'jobs',
            component: Jobs,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/jobs/:id',
            name: 'job',
            component: Job,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/login",
            name: 'login',
            component: Login
        }
    ]
})

router.beforeEach((to, from ,next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (localStorage.getItem('token') == null) {
            next({
                name: 'login',
                params: { nextUrl: to.fullPath }
            })
        } else {
            next()
        }
    } else if (to.matched.some(record => record.name == "login")) {
        if (localStorage.getItem('token') != null) {
            next({
                name: 'jobs'
            })
        } else {
            next()
        }
    } else {
        next()
    }
})

const app = new Vue({
    el: '#app',
    components: { App },
    router
})
