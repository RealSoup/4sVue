import Vue from 'vue';
import Router from 'vue-router';

import Pic01 from '@/views/web/page/Pic01';
import Pic02 from '@/views/web/page/Pic02';

import Main from '@/views/web/Main';
import Login from '@/views/web/auth/Login';

import Board from '@/views/web/board/Index';
import BoCreate from '@/views/web/board/Create';







Vue.use(Router)
// export default new Router({
export default new Router({
    mode: 'history',
    base: process.env.APP_URL,
    routes: [ {
            path: '/',
            name: 'main',
            component: Main
        }, {
            path: '/login',
            name: 'login',
            component: Login
        }, {
            path: '/pic01',
            name: 'pic01',
            component: Pic01
        }, {
            path: '/pic02',
            name: 'pic02',
            component: Pic02
        }, {
            path: '/board/:bo_cd',
            name: 'board',
            component: Board
            // component:() => import('./web/board/List.vue')
        }, {
            path: '/board/:bo_cd/create',
            name: 'bo_create',
            component: BoCreate
            // component:() => import('./web/board/List.vue')
        },

    ]
})
