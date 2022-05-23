import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import axios from 'axios';
import store from './index';
import { HorseInterface } from '../Types/Horse';
import { UserInterface } from '../Types/User';
import { InformationInterface } from '../Types/Information';
import Admin from '../Types/Admin';

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
    notifs: null,
    
    admin_data: null as Admin,
    admin_data_loading: false
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
    },

    SET_NOTIFICATIONS(state, notifications: InformationInterface) {
      state.notifs = notifications;
    },

    SET_ADMIN_DATA(state, admin_data: Admin) {
      state.admin_data = admin_data;
    }
  },
  actions: {
    async updateNotifs({state, commit}) {
      let {data} = await axios.get(`http://localhost:8000/api/users/${state.user?.id}/advertisements`, {
          headers: {
              'Authorization': 'Bearer ' + state.user?.api_token
          }
      })

      if(data.success) {
          commit('SET_NOTIFICATIONS', data.success)
      }
    }
  },
  modules: {},
  getters: {}
})
