import Vue from 'vue';
import VueRouter from 'vue-router';

import router from './Router/index';
import store from './Store/index';
import App from './App.vue';
import vuetify from './Vuetify/index';

import VCalendar from 'v-calendar';


Vue.use(VueRouter);
Vue.use(VCalendar)

new Vue({
  router,
  store,
  vuetify,
  render: h => h(App)
}).$mount('#app')
