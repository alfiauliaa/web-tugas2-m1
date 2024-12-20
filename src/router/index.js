//import vue router
import { createRouter, createWebHistory } from 'vue-router'

//define a routes
const routes = [
    {
        path: '/',
        name: 'home',
        component: () => import(/* webpackChunkName: "home" */
        '../views/home.vue')
    },
    {
        path: '/posts',
        name: 'posts.index',
        component: () => import(/* webpackChunkName: "posts-index" */
        '../views/posts/index.vue')
    },
    {
        path: '/create',
        name: 'posts.create',
        component: () => import(/* webpackChunkName: "posts-create" */
        '../views/posts/create.vue')
    },
    {
        path: '/edit/:id',
        name: 'posts.edit',
        component: () => import(/* webpackChunkName: "posts-edit" */
        '../views/posts/edit.vue')
    },

    // Routes untuk comments
    {
        path: '/comments',
        name: 'comments.index',
        component: () => import(/* webpackChunkName: "comments-index" */
        '../views/comments/index2.vue')
    },
    {
        path: '/comments/create',
        name: 'comments.create',
        component: () => import(/* webpackChunkName: "comments-create" */
        '../views/comments/create2.vue')
    },
    {
        path: '/comments/edit/:id',
        name: 'comments.edit',
        component: () => import(/* webpackChunkName: "comments-edit" */
        '../views/comments/edit2.vue')
    }
]

//create router
const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router