import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

import Layout from '@/views/layout/Layout';

import backendUserRouter from './modules/backendUser'
import settingRouter from './modules/setting'
import ContentRouter from './modules/content'

export const constantRouterMap = [
    {
        path: '/login',
        component: () => import('@/views/login/index'),
        hidden: true
    },
    {
        path: '/logout',
        redirect: '/login'
    },
    {
        path: '/404',
        component: () => import('@/views/error-page/404'),
        hidden: true
    },
    {
        path: '',
        component: Layout,
        redirect: 'dashboard',
        children: [
            {
                path: 'dashboard',
                component: () => import('@/views/dashboard/index'),
                name: 'dashboard',
                meta: { title: 'dashboard', icon: 'dashboard', noCache: true }
            }
        ]
    },
    {
        path: '/banner', // Banner
        component: Layout,
        children: [
            {
                path: 'index',
                component: () => import('@/views/banner/index'),
                name: 'Banner',
                meta: { title: 'banner', icon: 'list', noCache: true }
            }
        ]
    },
    {
        path: '/app_content',
        component: Layout,
        redirect: '/app_content/index',
        name: 'AppContent',
        meta: {
            title: 'appContent',
            icon: 'table'
        },
        children: [
            {
                path: 'cat',
                component: () => import('@/views/content/cat'),
                name: 'ContentCat',
                meta: { title: 'appContentCat' }
            },
            {
                path: 'index',
                component: () => import('@/views/content/index'),
                name: 'AppContentIndex',
                meta: { title: 'content' }
            },
            {
                path: 'index/create',
                component: () => import('@/views/content/new'),
                name: 'NewContent',
                meta: { title: 'newContent', noCache: true, parentPath: '/app_content/index' },
                hidden: true
            },
            {
                path: 'index/edit/:id',
                component: () => import('@/views/content/edit'),
                name: 'EditContent',
                meta: { title: 'editContent', noCache: true, parentPath: '/app_content/index' },
                hidden: true
            }
        ]
    },
    {
        path: '/prize', //奖品
        component: Layout,
        children: [
            {
                path: 'index',
                component: () => import('@/views/prize/index'),
                name: 'Prize',
                meta: { title: 'prize', icon: 'star', noCache: true }
            }
        ]
    },
    {
        path: '/campus', //校区
        component: Layout,
        children: [
            {
                path: 'index',
                component: () => import('@/views/campus/index'),
                name: 'Campus',
                meta: { title: 'campus', icon: 'component', noCache: true }
            }
        ]
    },
    {
        path: '/user',
        component: Layout,
        children: [
            {
                path: 'index',
                component: () => import('@/views/app-user/index'),
                name: 'AppUser',
                meta: { title: 'appUser', icon: 'peoples', noCache: true }
            }
        ]
    },
    {
        path: '/word',
        component: Layout,
        children: [
            {
                path: 'index',
                component: () => import('@/views/word/index'),
                name: 'Word',
                meta: { title: 'word', icon: 'excel', noCache: true }
            }
        ]
    }
]

export default new Router({
    mode: 'history',
    scrollBehavior: () => ({ y: 0 }),
    routes: constantRouterMap
})

export const asyncRouterMap = [
    ContentRouter,
    backendUserRouter,
    settingRouter,
    { path: '*', redirect: '/404', hidden: true }
]