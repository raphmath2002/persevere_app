import VueRouter, { RouteConfig } from 'vue-router'


import Home from '../Pages/Home.vue'
import Login from '../Pages/Login.vue'


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
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router;
