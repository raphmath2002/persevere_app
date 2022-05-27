import VueRouter, { RouteConfig } from 'vue-router'

import Home from '../Pages/Home.vue'
import Login from '../Pages/Login.vue'
import Horses from '../Pages/Horses.vue'
import Profile from '../Pages/Profile.vue'
import Notifications from '../Pages/Notifications.vue'
import Tickets from '../Pages/Tickets.vue'
import Bookings from '../Pages/Bookings.vue'
import PensionOption from '../Pages/admin/PensionsOptions.vue'

import Dashboard from '../Pages/admin/Dashboard.vue'
import Users from '../Pages/admin/Users.vue'
import AdminHorses from '../Pages/admin/Horses.vue'
import Professionals from '../Pages/admin/Professionals.vue'
import Visits from '../Pages/admin/Visits.vue'
import Facilities from '../Pages/admin/Facilities.vue'
import Advertisements from '../Pages/admin/Advertisements.vue'


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
    },

    {
      path: '/admin/horses',
      name: "api-horses",
      component: AdminHorses
    },

    {
      path: '/admin/professionals',
      name: "professionals",
      component: Professionals
    },

    {
      path: '/admin/visits',
      name: "visits",
      component: Visits
    },

    {
      path: '/tickets',
      name: "tickets",
      component: Tickets
    },

    {
      path: '/admin/facilities',
      name: "facilities",
      component: Facilities
    },

    {
      path: '/subscriptions',
      name: "subscriptions",
      component: PensionOption
    },

    {
      path: '/bookings',
      name: 'user-bookings',
      component: Bookings
    },

    {
      path: '/admin/advertisements',
      name: 'admin-adverts',
      component: Advertisements
    }
    


]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router;
