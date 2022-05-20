import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import axios from 'axios';
import store from './index';

Vue.use(Vuex);

/* eslint-disable  @typescript-eslint/no-explicit-any */

export default new Vuex.Store({
  plugins: [createPersistedState()],
  state: {
    user: null,
    logged: false,
    show_interface: false
  },
  mutations: {
    SHOW_INTERFACE(state, mode: boolean) {
      state.show_interface = mode;
    },

    LOGGED(state, mode: boolean) {
      state.logged = mode;
    }
  },
  actions: {},
  modules: {
  },
  getters: {}
})
