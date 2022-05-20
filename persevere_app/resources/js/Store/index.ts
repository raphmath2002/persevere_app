import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import axios from 'axios';
import store from './index';

Vue.use(Vuex);

/* eslint-disable  @typescript-eslint/no-explicit-any */

export default new Vuex.Store({
  plugins: [createPersistedState()],
  state: {},
  mutations: {},
  actions: {},
  modules: {
  },
  getters: {}
})
