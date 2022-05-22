import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import axios from 'axios';
import store from './index';
import { HorseInterface } from '../Types/Horse';
import { UserInterface } from '../Types/User';

Vue.use(Vuex);

/* eslint-disable  @typescript-eslint/no-explicit-any */

export default new Vuex.Store({
  plugins: [createPersistedState()],
  state: {
    user: null,
    logged: false,
    show_interface: false,
    notifications: false,
    mobile: false,
    notifs: null
  },
  mutations: {
    SET_USER(state, user: UserInterface) {
      state.user = user
    },
    SHOW_INTERFACE(state, mode: boolean) {
      state.show_interface = mode;
    },

    LOGGED(state, logged: boolean) {
      state.logged = logged;
    }
  },
  actions: {

  },
  modules: {},
  getters: {}
})
