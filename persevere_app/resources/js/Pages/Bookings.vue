<template>
    <div class="booking-page">
        <v-container>
            <v-row>
                <v-col>
                    <div class="d-flex justify-space-between">
                        <h1>Réservations</h1>
                        <v-icon @click="createBookingDialog = true" size="50px" color="green">mdi-plus</v-icon>
                    </div>
                </v-col>
            </v-row>

            <v-row class="visits-list" >
                <div v-for="horse in adminOrCustomerView" :key="horse.id">
                     <v-col v-for="booking in horse.appointments" :key="booking.id">
                        <BookingViewComponent :booking="booking" :horse="horse" />
                    </v-col>
                </div>
               
            </v-row>

            <v-dialog
                v-model="createBookingDialog"
                :fullscreen="$vuetify.breakpoint.xsOnly"

            >
                <BookingEditComponent @done="createBookingDialog = false" :new="true"/>
            </v-dialog>
        </v-container>
    </div>
</template>

<script lang="ts">
import {Vue, Component} from "vue-property-decorator"
import BookingEditComponent from "../Components/Bookings/BookingEditComponent.vue"
import BookingViewComponent from "../Components/Bookings/BookingViewComponent.vue"

import axios from "axios"


@Component({
    components: {
        BookingEditComponent,
        BookingViewComponent
    }
})
export default class Bookings extends Vue {

    private get user() {
        return this.$store.state.user;
    }

    private get admin_data() {
        return this.$store.state.admin_data;
    }

    private bookings = []

    private get adminOrCustomerView() {
        if(this.user.auth_level == 'customer') return this.user.horses;
        else return this.admin_data.horses;
    }

    private createBookingDialog = false;

    private mounted() {
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