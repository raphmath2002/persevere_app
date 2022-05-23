import VueRouter, { RouteConfig } from 'vue-router'


import Home from '../Pages/Home.vue'
import Login from '../Pages/Login.vue'
import Horses from '../Pages/Horses.vue'
import Profile from '../Pages/Profile.vue'
import Notifications from '../Pages/Notifications.vue'

import Dashboard from '../Pages/admin/Dashboard.vue'
import Users from '../Pages/admin/Users.vue'



const routes: Array<RouteConfig> = [
    {
        path: '/',
        name: 'home',
        component: Home
    },

    {
      path: '/notifications',
      name: "notifications",
      component: Notifications
    },

    {
      path: '/login',
      name: 'login',
      component: Login
    }, 

    {
      path: '/horses',
      name: 'horses',
      component: Horses
    },

    {
      path: '/profile',
      name: "profile",
      component: Profile
    },

    {
      path: '/admin/dashboard',
      name: "dashboard",
      component: Dashboard
    },

    {
      path: '/admin/users',
      name: "users",
      component: Users
    }

    


]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router;
