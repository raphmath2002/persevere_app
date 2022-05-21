<template>
    <v-col>
        <div class="horse-component">
            <div 
                @click="horseDetailsDialog = true"
                class="horse-widget d-flex justify-space-between"
                :style="`border-color:${sexIcon.color}; background:${horse.sex != 'male' ? 'rgb(255, 0, 255, .1)' : 'rgb(0, 0, 255, .1)'}`"
            >
                <v-img class="horse-avatar" :src="horse.storage_path"></v-img>
                <div class="horse-details d-flex flex-column justify-center">
                    <span class="horse-name">{{horse.name}}</span>
                    <span class="horse-added-at">Ajouté(e) le {{horse.created_at}}</span>
                </div>

                <div class="sex-container">
                    <div class="sex-icon-container">
                        <v-icon :color="sexIcon.color">{{sexIcon.icon}}</v-icon>
                    </div>
                </div>
            </div>
        </div>

        <v-dialog
            v-model="horseDetailsDialog"
            :fullscreen="$vuetify.breakpoint.xsOnly"
            width="auto "
        >
        <v-card>
            <v-card-title class="text-h5 d-flex justify-space-between">
                <span>Page de {{horse.name}}</span>
                <v-icon @click="horseDetailsDialog = false" color="red">mdi-close</v-icon>
            </v-card-title>

            <v-card-text>
                <div class="avatar-container">
                    <v-img class="horse-details-avatar" :src="horse.storage_path"></v-img>
                    <span>Inscrit(e) le {{horse.created_at}}</span>
                </div>

                <v-card class="card">
                    <v-card-title><span class="card-title">Caractéristiques</span></v-card-title>
                    <v-card-text>
                        <ul>
                            <li><span>Taille :</span> {{horse.size}} m</li>
                            <li><span>Poids :</span> {{horse.weigth}} kg</li>
                            <li><span>Sexe :</span> {{horse.sex}}</li>
                        </ul>
                    </v-card-text>
                </v-card>

                <v-card class="card">
                    <v-card-title>
                        <span class="card-title">Son planning</span>
                    </v-card-title>

                    <v-container>
                        <div class="d-flex justify-center">
                            <v-calendar />
                        </div>
                    </v-container>
                </v-card>

               <v-card class="card">
                   <v-card-title>
                      <span class="card-title">Soins prodigués</span>
                   </v-card-title>

                   <v-card-text>
                        <div class="treatments">
                            <div class="treatment">
                                <span class="treatment-name">Vermifugation</span>
                                <span class="treatment-date">Prodigué le 12/05/2020</span>
                            </div>
                        </div>

                        
                        <div class="treatments">
                            <div class="treatment">
                                <span class="treatment-name">Vermifugation</span>
                                <span class="treatment-date">Prodigué le 12/05/2020</span>
                            </div>
                        </div>

                        
                        <div class="treatments">
                            <div class="treatment">
                                <span class="treatment-name">Vermifugation</span>
                                <span class="treatment-date">Prodigué le 12/05/2020</span>
                            </div>
                        </div>
                   </v-card-text>
               </v-card>

               <v-card class="card">
                   <v-card-title>
                       <span class="card-title">Identification</span>
                   </v-card-title>

                   <v-card-text>
                       <ul>
                           <li><span>SIRE :</span> 7878451515</li>
                           <li><span>UELN :</span> 7878451515</li>
                           <li><span>Né(e) le :</span> 19/03/2015</li>
                           <li><span>Pays :</span> FRANCE</li>
                       </ul>
                   </v-card-text>
               </v-card>
            </v-card-text>
        </v-card>
        </v-dialog>
    </v-col>
</template>

<script lang="ts">
import {Vue, Component, Prop} from "vue-property-decorator"

import Horse, {HorseInterface} from '../Types/Horse'

@Component
export default class FacilityComponent extends Vue {
    @Prop({default: Horse.emptyHorse()}) readonly horse!: HorseInterface

    private horseDetailsDialog = false;

    private get sexIcon(): {icon: string, color: string} {
        if(this.horse) {
            switch(this.horse.sex) {
                case "male":
                    return {icon: "mdi-gender-male", color: "blue"}
                default:
                    return {icon: "mdi-gender-female", color: "pink"}
            }
        } 
        return {icon: "mdi-gender-male", color: "blue"}
    }
    mounted() {
        console.log(this.horse)
    }

}

</script>

<style scoped>
    .horse-avatar {
        max-height: 80px;
        max-width: 80px;

        border-radius: 50px;
    }

    .horse-name {
        font-weight: bold;
        font-size: 20px;
    }

    .horse-widget {
        border: solid 2px;
        
        padding: 8px 15px 8px 15px;
        margin: 5px 0 5px 0;

        border-radius: 30px;
    }

    .avatar-container {
        height: 250px;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        align-items: center;
    }

    .horse-details-avatar {
        max-width: 200px;
        max-height: 200px;

        border-radius: 100px;
    }

    .card {
        margin: 30px 0 30px 0;
    }

    .card-title {
        font-weight: bold;
    }

    ul {
        list-style: none;
    }

    ul span {
        font-weight: bold;
    }


</style>