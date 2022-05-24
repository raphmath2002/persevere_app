import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import axios from 'axios';
import store from './index';
import { HorseInterface } from '../Types/Horse';
import { UserInterface } from '../Types/User';
import { InformationInterface } from '../Types/Information';
import Admin from '../Types/Admin';
import { TicketInterface } from '../Types/Ticket';

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
    tickets: [],
    
    admin_data: {
      horses: [],
      users: [],
      appointments: [],
      facilities: [],
      advertisements: [],
      tickets: [],
      options: [],
      pensions: [],
      professionals: []
    },

    admin_data_loading: false
  },
  mutations: {
    SET_USER_TICKETS(state, tickets) {
      state.user.tickets = tickets;
    },

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

    SET_HORSES(state, horses) {
      state.admin_data.horses = horses;
    },

    SET_USERS(state, users) {
      state.admin_data.users = users;
    },

    SET_APPOINTMENTS(state, appointments) {
      state.admin_data.appointments = appointments;
    },

    SET_FACILITIES(state, facilities) {
      state.admin_data.facilities = facilities;
    },

    SET_ADVERTISEMENTS(state, advertisements) {
      state.admin_data.advertisements = advertisements;
    },

    SET_TICKETS(state, tickets) {
      state.admin_data.tickets = tickets;
    },

    SET_OPTIONS(state, options) {
      state.admin_data.options = options;
    },

    SET_PENSIONS(state, pensions) {
      state.admin_data.pensions = pensions;
    },

    SET_PROFESSIONALS(state, professionals) {
      state.admin_data.professionals = professionals;
    },
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
    },

    async update({state, commit}, choice: string) {

      if(choice == 'horses' || choice == "all")
      {
        let horses = await axios.get('http://localhost:8000/api/horses', {
              headers: {
                  "Authorization": "Bearer " + state.user.api_token
              }
        });

        if(horses.data.success) commit('SET_HORSES', horses.data.success);
      }

     
      if(choice == 'users' || choice == "all")
      {
        let users = await axios.get('http://localhost:8000/api/users', {
              headers: {
                  "Authorization": "Bearer " + state.user.api_token
              }
        })

        if(users.data.success) commit('SET_USERS', users.data.success);
      }


      if(choice == 'appointments' || choice == "all")
      {
        let appointments = await axios.get('http://localhost:8000/api/appointments', {
          headers: {
              "Authorization": "Bearer " + state.user.api_token
          }
        })

        if(appointments.data.success) commit('SET_APPOINTMENTS', appointments.data.success);
      }


      if(choice == 'facilities' || choice == "all")
      {
        let facilities = await axios.get('http://localhost:8000/api/facilities', {
          headers: {
              "Authorization": "Bearer " + state.user.api_token
          }
        })

        if(facilities.data.success) commit('SET_FACILITIES', facilities.data.success);
      }

      if(choice == 'advertisements' || choice == "all")
      {
        let advertisements = await axios.get('http://localhost:8000/api/advertisements', {
          headers: {
              "Authorization": "Bearer " + state.user.api_token
          }
        })

        if(advertisements.data.success) commit('SET_ADVERTISEMENTS', advertisements.data.success);
      }

      if(choice == 'tickets' || choice == "all")
      {
        let tickets = await axios.get('http://localhost:8000/api/tickets', {
          headers: {
              "Authorization": "Bearer " + state.user.api_token
          }
        })

        if(tickets.data.success) commit('SET_TICKETS', tickets.data.success);
      }

      if(choice == 'options' || choice == "all")
      {
        let options = await axios.get('http://localhost:8000/api/options', {
          headers: {
              "Authorization": "Bearer " + state.user.api_token
          }
        })

        if(options.data.success) commit('SET_OPTIONS', options.data.success);
      }

      if(choice == 'pensions' || choice == "all")
      {
        let pensions = await axios.get('http://localhost:8000/api/pensions', {
          headers: {
              "Authorization": "Bearer " + state.user.api_token
          }
        })

        if(pensions.data.success) commit('SET_PENSIONS', pensions.data.success);
      }

      if(choice == 'professionals' || choice == "all")
      {
        let professionals = await axios.get('http://localhost:8000/api/professionals', {
          headers: {
              "Authorization": "Bearer " + state.user.api_token
          }
        })

        if(professionals.data.success) commit('SET_PROFESSIONALS', professionals.data.success);
      }
    }
  },
  modules: {},
  getters: {}
})
