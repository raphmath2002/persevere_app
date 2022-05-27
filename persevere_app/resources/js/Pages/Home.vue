<template>
    <v-container>
        <div class="home-page">
            <div class="page-top">
                <h1>Accueil</h1>
            </div>
            
            
            <div class="page-content">
                <v-container>
                    <div class="preview">
                        <div class="preview-top">
                            <h2 @click="$router.push({name: 'horses'})" class="preview-title">Mes chevaux</h2>
                            <v-icon color="black">mdi-chevron-right-circle-outline</v-icon>
                        </div>
                        

                        <div class="preview-container">
                            
                            <v-img 
                                v-for="horse in user.horses"
                                :key="horse.id"
                                class="horse"
                                height="100"
                                :src="horse.storage_path"
                            ></v-img>
                        </div>
                    </div>
                </v-container>
            </div>
        </div>
    </v-container>
</template>

<script lang="ts">

import {Vue, Component} from "vue-property-decorator"
import Horse, {HorseInterface} from '../Types/Horse'
import { UserInterface } from "../Types/User";

@Component
export default class Home extends Vue {
    private get logged(): boolean{
        return this.$store.state.logged;
    }

    private get user(): UserInterface{
        return this.$store.state.user;
    }

    async mounted() {
        if(!this.logged) this.$router.push({name: 'login'});
    }

    private loading = false;



    private horses: HorseInterface[]

    private facilities = [
        {id: 1, name: "Super box", image: "https://picsum.photos/200/300"},
        {id: 2, name: "Super box", image: "https://picsum.photos/200/300"},
        {id: 3, name: "Super box", image: "https://picsum.photos/200/300"},
        {id: 4, name: "Super box", image: "https://picsum.photos/200/300"},
        {id: 5, name: "Super box", image: "https://picsum.photos/200/300"},
    ]

}

</script>

<style scoped>

    .page-content{
        width: 100%;
        height: 80%;
        padding: 5px 10px 5px 10px;
    }

    .preview-container {
        display: flex;

        overflow-x: auto;
    }

    .horse {
        max-width: 100px;
        max-height: 100px;

        margin: 0 15px 0 15px;

        border-radius: 50px;
    }

    .preview-title {
        margin: 0 15px 0 0;
    }

    .facility {
        margin: 0 15px 0 15px;
    }

    .preview-top {
        display: flex;
        align-items: center;

        margin: 0 0 10px 0;
    }
</style>