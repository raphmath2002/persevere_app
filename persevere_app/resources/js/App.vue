<template>
  <v-app>
    <v-main>
      <router-view></router-view>
    </v-main>

    <div v-if="sh_interface" class="mobile-menu">
      <div class="top-menu">
        <div class="logout-container">
          <v-icon size="50px">mdi-logout</v-icon>
        </div>
      </div>

      <nav class="middle-menu">
        <ul>
          <li>Accueil</li>
          <li>Mes chevaux</li>
          <li>Réserver</li>
          <li>Mes rendez-vous</li>
          <li>Mes installations</li>
        </ul>
      </nav>

      <div class="bottom-menu">
        <div class="menu-profile-picture">

        </div>

        <span>Louis</span>
      </div>
    </div>

    <div v-if="sh_interface" class="mobile-burger">
      <div class="mobile-burger-btn">
        <v-icon size="80px">mdi-menu</v-icon>
      </div>
    </div>

  </v-app>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import axios from 'axios';

@Component
export default class App extends Vue {

  private get sh_interface(): boolean {
    return this.$store.state.show_interface;
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
    }

    .mobile-burger-btn {
      border: solid blue 1px;
      position: absolute;
      padding: 5px;
      border-radius: 50px;

      left: 20px;
      bottom: 20px;

      background-color: white;
    }

    .mobile-menu {
      padding: 30px 0 20px 20px;
      border: solid red 1px;
      position: fixed;
      width: 70%;
      height: 100%;

      background-color: white;
      z-index: 50;

      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
</style>
