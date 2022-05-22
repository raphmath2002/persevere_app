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
        <ul>
          <li @click="goToRoute('home')">
            <v-icon color="black" size="40px">mdi-home</v-icon>
            <span>Accueil</span>
          </li>

          <li @click="goToRoute('horses')">
            <v-icon color="black" size="40px">mdi-horse</v-icon>
            <span>Mes chevaux</span>
          </li>

          <li @click="goToRoute('book')">
            <v-icon color="black" size="40px">mdi-calendar-plus</v-icon>
            <span>Réserver</span>
          </li>

          <li @click="goToRoute('bookings')">
            <v-icon color="black" size="40px">mdi-calendar-month</v-icon>
            <span>Mon planning</span>
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
          <div @click="switchMobileMenu" class="mobile-burger-btn">
            <v-icon size="50px">mdi-menu</v-icon>
          </div>

          <div class="mobile-burger-btn notif">
            <v-icon v-if="!haveNotif" size="40px">mdi-bell</v-icon>
            <v-icon v-else size="40px">mdi-bell-badge</v-icon>
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

  private goToRoute(route: string): void {
    this.switchMobileMenu();
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

      border: solid red 1px;
      position: fixed;

      height: 70px;
      width: 100%;

      bottom: 0;

      z-index: 10;
      background-color: white;
    }

    .mobile-burger-btns {
      position: absolute;

      left: 20px;
      bottom: 35px;

      width: 140px;
    }

    .mobile-burger-btn {
      border: solid blue 1px;
      padding: 5px;
      border-radius: 50px;
      background-color: white;
    }

    .mobile-menu {
      padding: 30px 20px 20px 20px;
      border: solid red 1px;
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

    .middle-menu > ul {
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
