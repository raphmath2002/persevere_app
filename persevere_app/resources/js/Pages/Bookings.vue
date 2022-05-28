<template>
    <div class="booking-page">
        <v-container>
            <v-row>
                <v-col>
                    <div class="d-flex justify-space-between">
                        <h1>Réservations</h1>
                        <v-icon 
                            @click="createBookingDialog = true" 
                            v-if="user.auth_level=='customer'" 
                            size="50px" 
                            color="green"
                        >mdi-plus</v-icon>
                    </div>
                </v-col>
            </v-row>

            <v-col cols="12">
                <v-select
                    :items="booking_types"
                    v-model="selected_type"
                    item-text="name"
                    item-value="value"

                    dense
                    outlined
                    filled
                ></v-select>
            </v-col>

            <v-row v-if="selected_type == 'bookings'">
                <v-col>
                    <v-select
                        :items="status_list"
                        v-model="filter_status"
                        item-text="name"
                        item-value="value"

                        dense
                        outlined
                        filled
                    >
                    </v-select>
                </v-col>

                <div v-for="horse in adminOrCustomerView" :key="horse.id">
                     <v-col v-for="booking in horse.appointments" :key="booking.id">
                        <BookingViewComponent v-if="booking.pivot.status == filter_status || filter_status == 'all'" :booking="booking" :horse="horse" />
                    </v-col>
                </div>
            </v-row>
            <v-row v-else>
                <v-col cols="12" v-for="facility_horse in facility_horse_list" :key="facility_horse.id">
                    <v-card @click="selectFacilityHorse(facility_horse)" dark>
                        <v-card-title>
                            <h4>{{facility_horse.name}}</h4>
                        </v-card-title>

                        <v-card-text>
                            <span><strong>Réservé pour : </strong>{{facility_horse.horse.name}}</span>
                            <span><strong>Du </strong>{{formatDate(facility_horse.start_date)}} <strong>au </strong>{{formatDate(facility_horse.end_date)}}</span>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>

            <v-dialog
                v-model="viewFacilityHorse"
                :fullscreen="$vuetify.breakpoint.xsOnly"
            >
                <v-card>
                    <v-card-title class="d-flex justify-space-between">
                        <h3>Installation</h3>
                        <v-icon color="red" size="50px" @click="viewFacilityHorse = false">mdi-close</v-icon>
                    </v-card-title>

                    <v-card-text>
                        <v-row>
                            <v-col cols="12">
                                <h3>{{selected_facility_horse.name}}</h3>
                            </v-col>
                            <v-col cols="12">
                                <span><strong>Du </strong>{{selected_facility_horse.start_date}} <strong>au </strong>{{selected_facility_horse.end_date}}</span>
                            </v-col>

                            <v-col cols="12">
                                <h3>Pour</h3>
                                <HorseComponent :horse="selected_facility_horse.horse" />
                            </v-col>

                            <v-col cols="12">
                                <span><strong>Status : </strong>{{selected_facility_horse.status}}</span>
                            </v-col>

                            <v-row v-if="selected_facility_horse.status == 'canceled'">
                                <v-col cols="12">
                                    <span><strong>Raison de l'annulation : </strong>{{selected_facility_horse.decline_reason}}</span>
                                </v-col>
                            </v-row>

                            <v-row v-if="selected_facility_horse.status == 'reserved'">
                                <v-col cols="12" class="d-flex">
                                    <v-text-field
                                        v-model="decline_reason"
                                        filled
                                        outlined
                                        dense
                                        label="Raison de l'annulation"
                                    ></v-text-field>
                                    <v-btn color="red" @click="cancelFacilityHorse">Annuler</v-btn>
                                </v-col>
                            </v-row>


                        </v-row>
                    </v-card-text>
                </v-card>
            </v-dialog>

            <v-dialog
                v-model="createBookingDialog"
                :fullscreen="$vuetify.breakpoint.xsOnly"
            >
                <BookingEditComponent @done="reload_data" :new="true"/>
            </v-dialog>
        </v-container>
    </div>
</template>

<script lang="ts">
import {Vue, Component} from "vue-property-decorator"
import BookingEditComponent from "../Components/Bookings/BookingEditComponent.vue"
import BookingViewComponent from "../Components/Bookings/BookingViewComponent.vue"
import HorseComponent from "../Components/HorseComponent.vue"

import axios from "axios"
import { UserInterface } from "../Types/User";


@Component({
    components: {
        BookingEditComponent,
        BookingViewComponent,
        HorseComponent
    }
})
export default class Bookings extends Vue {

    private get user(): any {
        return this.$store.state.user;
    }

    private decline_reason = ""

    private viewFacilityHorse = false;

    private selected_type = "bookings"

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

    private selectFacilityHorse(falicity_horse) {
        this.selected_facility_horse = falicity_horse;
        this.viewFacilityHorse = true
    }

    private selected_facility_horse: any = {
        decline_reason: "",
        description: "",
        end_date: "00/00/00 00:00:00",
        horse: {},
        id: 0,
        name: "",
        start_date: "00/00/00 00:00:00",
        status: "",
    };

    private booking_types = [
        {name: "Installations", value: "facilities"},
        {name: "Rendez-vous", value: "bookings"}
    ]

    private status_list = [
        {name: "Tous", value: "all"},
        {name: "En attente", value: "waiting"},
        {name: "Acceptés", value: "accepted"},
        {name: "Annulés", value: "canceled"},
        {name: "Refusés", value: "refused"},
        {name: "Terminés", value: "ended"},
    ]

    private filter_status = "all"

    private get admin_data() {
        return this.$store.state.admin_data;
    }

    private facility_horse_list = []

    private facilities = []

    private async reload_data() {
        let to_iterate = null

        this.selected_facility_horse = []

        if(this.user.auth_level == 'customer') {
            await axios.get(`http://localhost:8000/api/users/${this.user.id}/edit`, {
                headers: {
                    'Authorization': 'Bearer ' + this.user.api_token
                }
            }).then((res: any) => {
                if(res.data.success) {
                    to_iterate = res.data.success.horses
                }
            })
        }
        else to_iterate = this.admin_data.horses

        for(const horse of to_iterate)
        {
            for (const facility of horse.facilities) {
                
                this.facility_horse_list.push({
                    id: facility.pivot.id,
                    horse: horse,
                    start_date: facility.pivot.start_date,
                    end_date: facility.pivot.end_date,
                    description: facility.description,
                    name: facility.name,
                    status: facility.pivot.status,
                    decline_reason: facility.pivot.decline_reason
                })
            }
        }
        this.createBookingDialog = false
        console.log(this.facility_horse_list)
    }

    private async cancelFacilityHorse() {
        await axios.put(`http://localhost:8000/api/facilityHorse/${this.selected_facility_horse.id}/cancel`, {decline_reason: this.decline_reason}, {
            headers: {
                'Authorization': 'Bearer ' + this.user.api_token
            }
        }).then(async (res: any) => {
            if(res.data.success) {

                if(this.user.auth_lvl == 'customer') await this.reload_data();
                else await this.$store.dispatch('update', 'horses');
                this.viewFacilityHorse = false;
            }
        })
    }

    private bookings = []

    private get adminOrCustomerView() {
        if(this.user.auth_level == 'customer') return this.user.horses;
        else return this.admin_data.horses;
    }

    private createBookingDialog = false;

    private async mounted() {
        await this.reload_data()
        if(this.user.auth_level != 'customer') {
            for (const horse of this.admin_data.horses) {
                for (const booking of horse.appointments) {
                    this.bookings.push(booking)
                }
            }
        }
    }

}
</script>

<style>
    .booking-page {
        padding-bottom: 80px;
    }
</style>