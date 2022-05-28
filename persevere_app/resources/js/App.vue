<template>
  <v-app>
    <v-main>
      <router-view></router-view>
    </v-main>

    <div v-if="logged" class="mobile-menu">
      <div class="top-menu">
        <div class="logout-container">
          <v-icon @click="logout" size="50px">mdi-logout</v-icon>
        </div>
      </div>

      <nav class="middle-menu">
        <ul v-if="user.auth_level =='customer'">
          <li @click="goToRoute('home')">
            <v-icon color="black" size="40px">mdi-home</v-icon>
            <span>Accueil</span>
          </li>

          <li @click="goToRoute('horses')">
            <v-icon color="black" size="40px">mdi-horse</v-icon>
            <span>Mes chevaux</span>
          </li>

          <li @click="goToRoute('user-bookings')">
            <v-icon color="black" size="40px">mdi-calendar-plus</v-icon>
            <span>Mes réservations</span>
          </li>
        </ul>

        <ul v-else>
          <li @click="goToRoute('dashboard')">
            <v-icon color="black" size="40px">mdi-desktop-mac-dashboard</v-icon>
            <span>Dashboard</span>
          </li>

           <li @click="goToRoute('users')">
            <v-icon color="black" size="40px">mdi-account-group</v-icon>
            <span>Utilisateurs</span>
          </li>

          <li @click="goToRoute('professionals')">
            <v-icon color="black" size="40px">mdi-account-multiple</v-icon>
            <span>Professionnels</span>
          </li>

           <li @click="goToRoute('api-horses')">
            <v-icon color="black" size="40px">mdi-horse</v-icon>
            <span>Chevaux</span>
          </li>

           <li @click="goToRoute('user-bookings')">
            <v-icon color="black" size="40px">mdi-notebook</v-icon>
            <span>Réservations</span>
          </li>

           <li @click="goToRoute('facilities')">
            <v-icon color="black" size="40px">mdi-domain</v-icon>
            <span>Installations</span>
          </li>

           <li @click="goToRoute('admin-adverts')">
            <v-icon color="black" size="40px">mdi-bullhorn</v-icon>
            <span>Annonces</span>
          </li>

           <li @click="goToRoute('subscriptions')">
            <v-icon color="black" size="40px">mdi-currency-usd</v-icon>
            <span>Pensions / Options</span>
          </li>

          <li @click="goToRoute('visits')">
            <v-icon color="black" size="40px">mdi-calendar-month</v-icon>
            <span>Visites</span>
          </li>
        </ul>
      </nav>

      <div @click="goToRoute('profile')" class="bottom-menu">
        <div>
          <v-img class="menu-profile-picture" :src="user.storage_path"></v-img>
        </div>
        <span>{{user.name}}</span>
      </div>
    </div>

    <div v-if="isMobileMenuOpen && logged" @click="switchMobileMenu" class="app-hide"></div>

    <div v-if="logged" class="mobile-burger">
      <div class="mobile-burger-btns d-flex justify-space-between align-center"> 
          <div @click="switchMobileMenu"  class="mobile-burger-btn">
            <v-icon color="black" size="50px">mdi-menu</v-icon>
          </div>

          <div v-if="user.auth_level == 'customer'" @click="goToRoute('notifications', false)" class="mobile-burger-btn notif">
            <v-icon color="black" v-if="!haveNotif" size="40px">mdi-bell</v-icon>
            <v-icon color="black" v-else size="40px">mdi-bell-badge</v-icon>
          </div>

          <div @click="goToRoute('tickets', false)" class="mobile-burger-btn notif">
            <v-icon color="black" size="40px">mdi-lifebuoy</v-icon>
          </div>
      </div>
      
    </div>

  </v-app>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import axios from 'axios';
import User, { UserInterface } from './Types/User';
import { HorseInterface } from './Types/Horse';

@Component
export default class App extends Vue {

  private isMobileMenuOpen = false;

  private get user(): UserInterface {
    return this.$store.state.user;
  }

  private get haveNotif(): boolean {
    return this.$store.state.notifications;
  }

  private goToRoute(route: string, switchMenu=true): void {
    if(switchMenu) this.switchMobileMenu();
    this.$router.push({name: route});
  }

  private switchMobileMenu(): void {
    let menu: any = document.querySelector('.mobile-menu')

    if (this.isMobileMenuOpen) {
      menu.style.left = "-500px"
      this.isMobileMenuOpen = false
    } else {
      menu.style.left = "0"
      this.isMobileMenuOpen = true
    }
    
  }


  private logout(): void {
    this.switchMobileMenu()
    this.$store.commit("LOGGED", false);
    this.$store.commit("SET_USER", null)
    this.$router.push({name: 'login'})
    // TODO logout
  }

  private get logged(): boolean {
    return this.$store.state.logged;
  }
}
</script>

<style>
    .mobile-burger {
      position: fixed;

      height: 70px;
      width: 100%;

      bottom: 0;

      z-index: 10;
      background-color: rgb(194, 194, 194);
    }

    .mobile-burger-btns {
      position: absolute;

      left: 20px;
      bottom: 35px;

      width: 140px;
    }

    .mobile-burger-btn {
      padding: 5px;
      border-radius: 50px;
      background-color: rgb(230, 230, 230);
    }

    .mobile-menu {
      padding: 30px 20px 20px 20px;
      position: fixed;
      width: 70%;
      height: 100%;

      left: -500px;

      background-color: white;
      z-index: 50;

      display: flex;
      flex-direction: column;
      justify-content: space-between;

      transition: 0.5s ease-out;
    }

    .middle-menu {
      height: 40%;
    }

    .middle-menu li {
      font-size: 20px;
      font-weight: bold;


      display: flex;
      justify-content: space-between;
    }

    .middle-menu  ul {
      list-style: none;
      height: 100%;

      display: flex;
      flex-direction: column;
      justify-content: space-around;
    }

    .menu-profile-picture {
      width: 75px;
      height: 75px;

      border: solid black 1px;

      border-radius: 50px;

      margin-right: 20px;
    }

    .bottom-menu {
      display: flex;

      align-items: center;
      justify-content: flex-start;

      min-width: 200px;
    }

    .app-hide {
      position: fixed;
      width: 100%;
      height: 100%;

      background-color: black;

      opacity: 50%;

      transition: 1s ease-out;

      z-index: 40;
    }
</style>
