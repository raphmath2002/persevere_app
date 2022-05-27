<template>
    <v-container>
        <v-card dark @click="advertDialog = true">
            <v-card-title>
                <span>{{advert.title}}</span>  
            </v-card-title>
        </v-card>


        <v-dialog
            v-model="advertDialog"
            :fullscreen="$vuetify.breakpoint.xsOnly"

        >
            <v-card>
                <v-card-title class="d-flex justify-space-between">
                    <span>{{advert.title}}</span>
                    <div>
                        <v-icon @click="advertDialog = false" color="red">mdi-close</v-icon>
                        <v-icon @click="deleteAdvert" color="red">mdi-delete</v-icon>
                    </div>
                    
                </v-card-title>

                <v-card-text>
                    <vue-simple-markdown :source="advert.markdown"></vue-simple-markdown>
                </v-card-text>
            </v-card>
        </v-dialog>


        <v-dialog
            v-model="editAdvertDialog"
            :fullscreen="$vuetify.breakpoint.xsOnly"

        >
            <AdvertisementEditComponent @done="editAdvertDialog = false" :advert="advert" />
        </v-dialog>
    </v-container>
</template>

<script lang="ts">
import {Vue, Component, Prop} from "vue-property-decorator"
import { UserInterface } from "../../Types/User";
import {AppointmentInterface} from "../../Types/Appointment"
import { ProfessionalInterface } from "../../Types/Professional";
import AdvertisementEditComponent from './AdvertisementEditComponent.vue'
import axios from "axios";

@Component({
    components: {
        AdvertisementEditComponent
    }
})
export default class AdvertisementViewComponent extends Vue {
    @Prop() readonly advert!: any

    private editAdvertDialog = false;
    private advertDialog = false;

    private get user(): UserInterface{
        return this.$store.state.user;
    }

    private async deleteAdvert() {
        await axios.delete(`http://localhost:8000/api/advertisements/${this.advert.id}/destroy`, {
            headers: {
                'Authorization': 'Bearer ' + this.user.api_token
            }
        }).then( async (res: any) => {
            if(res.data.success) {
                await this.$store.dispatch('update', 'advertisements');
                this.advertDialog = false;
            }
        })
    }
}
</script>

<style>

</style>