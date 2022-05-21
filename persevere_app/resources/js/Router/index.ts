import VueRouter, { RouteConfig } from 'vue-router'


import Home from '../Pages/Home.vue'
import Login from '../Pages/Login.vue'
import Horses from '../Pages/Horses.vue'
import Profile from '../Pages/Profile.vue'


const routes: Array<RouteConfig> = [
    {
        path: '/',
        name: 'home',
        component: Home
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
    }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router;
