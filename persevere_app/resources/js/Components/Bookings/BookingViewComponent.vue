<template>
    <v-container>
        <v-card dark>
            <v-card-title>
                <h3>{{professional.name}} {{professional.firstname}}</h3>
            </v-card-title>

            <v-card-text>
                <div 
                    @click="viewOrEdit"
                    class="pro-widget d-flex align-center"
                >
                    <v-img max-width="100px" height="100px" class="pro-avatar" :src="horse.storage_path"></v-img>
                    
                    <div class="booking-container d-flex flex-column">
                        <span>Rendez-vous pour {{horse.name}}</span>
                        <span>Du {{formatDate(booking.start_date)}} au {{formatDate(booking.end_date)}}</span>
                    </div>
                </div>
            </v-card-text>
        </v-card>


        <v-dialog
            v-model="bookingDialog"
            :fullscreen="$vuetify.breakpoint.xsOnly"

        >
            <v-card>
                <v-card-title
                    class="d-flex justify-space-between"
                >
                    <h3>Réservation</h3>
                    <v-icon size="50px" color="red" @click="bookingDialog = false">mdi-close</v-icon>
                </v-card-title>

                <v-card-text>
                    <v-row>
                        <v-col>
                            <h3>Le professionnel</h3>
                            <ProViewComponent :professional="professional" />
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col dark>
                            <h3>Le cheval</h3>
                            
                            <HorseComponent :horse="horse" />
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col>
                            <v-card>
                                <v-card-title>
                                    Descriptif
                                </v-card-title>

                                <v-card-text class="d-flex flex-column">
                                    <span>Objet : {{booking.pivot.title}}</span>
                                    <span>Description : {{booking.pivot.description}}</span>
                                    <span>Status : <strong>{{booking.pivot.status}}</strong></span>

                                    <div v-if="booking.pivot.status == 'ended'" class="d-flex flex-column">
                                        <span>Soins effectués :  {{booking.pivot.cares}} </span>
                                        <span>Observations :  {{booking.pivot.observations}} </span>
                                    </div>

                                    <div v-if="booking.status == 'canceled' || booking.pivot.status == 'declined'">
                                        <span>Raison de l'annulation : {{booking.pivot.decline_reason}}</span> 
                                    </div>
                                </v-card-text>

                                <v-card-actions v-if="user.auth_level != 'customer'">
                                    <v-container>
                                        <v-row>
                                            <v-col class="d-flex align-center" cols="12" v-if="booking.pivot.status == 'waiting' || booking.pivot.status == 'accepted'">
                                                <v-btn @click="accept" v-if="booking.pivot.status == 'waiting'" color="green">Accepter</v-btn>
                                                <v-col v-else>
                                                    <v-form>

                                                                                    
                                                        <v-col
                                                            cols="12"
                                                            md="4"
                                                        >
                                                            <v-textarea
                                                                v-model="end_infos.cares"
                                                                label="Soins prodigués"
                                                            ></v-textarea>
                                                        </v-col>

                                                        <v-col
                                                            cols="12"
                                                            md="4"
                                                        >
                                                            <v-textarea
                                                                v-model="end_infos.observations"
                                                                label="Observations"
                                                            ></v-textarea>
                                                        </v-col>

                                                         <v-col
                                                            cols="12"
                                                            md="4"
                                                        >
                                                            <v-text-field
                                                                v-model.number="end_infos.price"
                                                                label="Prix (€)"
                                                            ></v-text-field>
                                                        </v-col>
                                                    </v-form>

                                                    <v-btn @click="close" color="primary">Terminer</v-btn>
                                                </v-col>
                                            </v-col>
                                            <v-col cols="12" v-if="booking.pivot.status == 'waiting' || booking.pivot.status == 'accepted'">
                                                <v-row>
                                                    <v-col cols="8">
                                                        <v-text-field
                                                            label="Raison de l'annulation"
                                                            v-model="decline_reason"
                                                        ></v-text-field>
                                                    </v-col>
                                                    <v-col cols="4">
                                                        <v-btn v-if="booking.pivot.status == 'waiting'" @click="decline" color="red">Refuser</v-btn>
                                                        <v-btn v-else @click="cancel" color="red">Annuler</v-btn>
                                                    </v-col>
                                                </v-row>        
                                            </v-col>
                                    </v-row>
                                    </v-container>
                                </v-card-actions>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script lang="ts">
import {Vue, Component, Prop} from "vue-property-decorator"
import { UserInterface } from "../../Types/User";
import axios from "axios"

import HorseComponent from "../HorseComponent.vue"
import ProViewComponent from "../Professionals/ProViewComponent.vue"


@Component({
    components: {
        HorseComponent,
        ProViewComponent
    }
})
export default class BookingViewComponent extends Vue {
    @Prop() readonly booking!: any
    @Prop() readonly horse!: any


    private professional = {name:""}

    private end_infos = {
        cares: "",
        price: 0,
        observations: ""
    }


    private editBookingDialog = false;
    private bookingDialog = false;

    private get user(): UserInterface{
        return this.$store.state.user;
    }

    private formatDate(_date: string) {
        let date = _date.split(" ")[0];
        let time = _date.split(" ")[1];

        let day = new Date(date).getDate().toString()
        let month: any = new Date(date).getMonth() + 1

        if(day.length < 2) day = `0${day}`
        if(`${month}`.length < 2) month = `0${month}`

        time = time.split(":")[0] + "h" + time.split(":")[1]

        return `${day}/${month} à ${time}`;
    }

    private decline_reason = ""

    private viewOrEdit() {
        this.bookingDialog = true;
    }

    private async decline() {
        await axios.put(`http://localhost:8000/api/appointmentHorse/${this.booking.pivot.id}/refuse`, {refuse_reason: this.decline_reason}, {
            headers: {
                'Authorization': 'Bearer ' + this.user.api_token
            }
        })

        await this.$store.dispatch('update', 'horses');
    }

    private async accept() {

        await axios.put(`http://localhost:8000/api/appointmentHorse/${this.booking.pivot.id}/accept`,{}, {
            headers: {
                'Authorization': 'Bearer ' + this.user.api_token
            }
        })
        await this.$store.dispatch('update', 'horses');
        
    }

    private async close() {
        await axios.put(`http://localhost:8000/api/appointmentHorse/${this.booking.pivot.id}/close`,this.end_infos, {
            headers: {
                'Authorization': 'Bearer ' + this.user.api_token
            }
        })
        await this.$store.dispatch('update', 'horses');

    }

    private async cancel() {
        await axios.put(`http://localhost:8000/api/appointmentHorse/${this.booking.pivot.id}/cancel`, {refuse_reason: this.decline_reason}, {
            headers: {
                'Authorization': 'Bearer ' + this.user.api_token
            }
        })
        await this.$store.dispatch('update', 'horses');

    }

    private async mounted() {
         await axios.get(`http://localhost:8000/api/professionals/${this.booking.professional_id}/edit`, {
            headers: {
                'Authorization': 'Bearer ' + this.user.api_token
            }
        }).then((res: any) => {

            this.professional = res.data.success})
    }
}
</script>

<style>
    .profession-container {
        padding: 5px 5px 5px 20px;
    }

    .pro-avatar {
        border-radius: 50px;
        margin: 5px 15px 5px 15px;
    }
</style>