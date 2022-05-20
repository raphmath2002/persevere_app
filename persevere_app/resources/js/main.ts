import Vue from 'vue';
import VueRouter from 'vue-router';

import router from './Router/index';
import store from './Store/index';
import App from './App.vue';
import vuetify from './Vuetify/index';

Vue.use(VueRouter);

new Vue({
  router,
  store,
  vuetify,
  render: h => h(App)
}).$mount('#app')
