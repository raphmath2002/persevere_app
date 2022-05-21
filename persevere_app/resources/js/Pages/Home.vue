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
                                class="horse"
                                height="100"
                                src="https://picsum.photos/200/300"
                            ></v-img>

                            <v-img
                                class="horse"
                                height="100"
                                src="https://picsum.photos/200/300"
                            ></v-img>

                            <v-img
                                class="horse"
                                height="100"
                                src="https://picsum.photos/200/300"
                            ></v-img>

                            <v-img
                                class="horse"
                                height="100"
                                src="https://picsum.photos/200/300"
                            ></v-img>

                        </div>
                    </div>
                </v-container>

                <v-divider></v-divider>

                <v-container>
                    <div class="preview">
                        <div @click="$router.push({name: 'facilities'})" class="preview-top">
                            <h2 class="preview-title">Mes installations</h2>
                            <v-icon color="black">mdi-chevron-right-circle-outline</v-icon>
                        </div>
                        

                        <div class="preview-container">
                            
                            <v-card
                                v-for="facility in facilities"
                                :key="facility.id"
                                :loading="loading"
                                class="facility"
                                max-width="374"
                            >

                                <v-img
                                height="100"
                                :src="facility.image"
                                ></v-img>

                                <v-card-title>{{facility.name}}</v-card-title>
                            </v-card>

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

@Component
export default class Home extends Vue {
    async mounted() {
        // TODO check user connecté
        if(1!=1) this.$router.push({name: 'login'});
    }

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

        border: solid blue 1px;

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