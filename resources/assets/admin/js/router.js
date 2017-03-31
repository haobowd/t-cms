import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)
import Admin from './views/Admin.vue'
import Home from './views/Home.vue'
import Login from './views/Login.vue'
export default new Router({
    mode: 'history',
    base: __dirname,
    routes: [
        {
            path: '/admin',
            component: Admin,
            children: [
                {
                    path: '/',
                    redirect: '/admin/home'
                },
                {
                    path: 'home',
                    name: 'home',
                    component: Home,
                    children: [
                        {
                            path: 'users',
                            name: 'users',
                            component: require('./views/userManage/Users.vue')
                        },
                        {
                            path: 'roles',
                            name: 'roles',
                            component: require('./views/userManage/Roles.vue')
                        }
                    ]
                },
                {
                    path: 'login',
                    name: 'login',
                    component: Login
                }
            ]
        },
        {
            path: '*',
            redirect: '/admin/home'
        },
    ]
})

