import VueRouter, { RouteConfig } from 'vue-router'


import Home from '../Pages/Home.vue'


const routes: Array<RouteConfig> = [
    // Site vitrine
    {
        path: '/',
        name: 'home',
        component: Home
    }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router;
