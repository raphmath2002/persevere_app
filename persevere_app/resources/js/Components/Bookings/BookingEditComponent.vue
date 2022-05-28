<template>
    <v-card>
        <v-card-title class="d-flex justify-space-between">
                <h2>Réserver</h2>
                <div>
                    <v-progress-circular
                        v-if="loading"
                        indeterminate
                        color="red"
                    ></v-progress-circular>
                    <v-icon v-else color="green" size="50px" @click="save">mdi-content-save</v-icon>
                    <v-icon color="red" size="50px" @click="$emit('done')">mdi-close</v-icon>
                </div>
        </v-card-title>

        <v-card-text>
            <v-form>
                <v-container>
                    <v-row>
                        <v-select
                            v-model="selected_booking_type"
                            :items="bookings_type"
                            item-text="name"
                            filled
                            outlined
                            dense
                            label="Quoi ?"

                            return-object
                        >
                        </v-select>

                        <div
                            v-if="selected_booking_type.value == 'appointmentHorse'"
                        >
                            <v-col
                                cols="12"
                                md="4"
                            >
                                <v-text-field
                                    v-model="booking_infos.title"
                                    label="Pourquoi prenez-vous rendez-vous ?"
                                ></v-text-field>
                            </v-col>

                            <v-col
                                cols="12"
                                md="4"
                            >
                                <v-textarea
                                    v-model="booking_infos.description"
                                    label="Quelques précisions sur ce rendez-vous ?"
                                ></v-textarea>
                            </v-col>

                            <v-col
                                cols="12"
                                md="4"
                            > 
                                <div
                                    v-if="!selected_visit"
                                    class="d-flex justify-center"
                                >
                                    <v-btn @click="selectVisitDialog = true" color="primary" dense>Choisir une visite</v-btn>
                                </div>

                                <v-row cols="12" v-else>

                                    <v-col cols="8">
                                        <VisitViewComponent :visit="selected_visit"/>

                                    </v-col>
                                    <v-col cols="4" class="d-flex align-center">
                                        <v-icon size="50px" color="primary" @click="selectVisitDialog = true">mdi-swap-horizontal</v-icon>
                                    </v-col>

                                    <v-col
                                        cols="12"
                                    >
                                        <v-select
                                            v-model="booking_infos.start_date"
                                            :items="free_schedules"
                                            label="Choisissez un créneau horaire"
                                        >
                                        </v-select>
                                    </v-col>
                                </v-row>

                                <v-col
                                    cols="12"
                                    md="4"
                                >
                                    <v-select
                                        label="Quel cheval"
                                        :items="user.horses"
                                        v-model.number="booking_infos.horse_id"
                                        item-text="name"
                                        item-value="id"
                                    >
                                    </v-select>
                                </v-col>
                            </v-col>
                        </div>

                        <div v-else>
                            <v-row>
                                <v-col
                                    v-for="facility in facilities"
                                    :key="facility.id"
                                    cols="12"
                                >
                                    <FacilityViewComponent :facility="facility" @done="$emit('done')"/>
                                </v-col>
                            </v-row>
                        </div>
                        

                    </v-row>
                </v-container>
            </v-form>
        </v-card-text>

        <v-dialog
            v-model="selectVisitDialog"
            :fullscreen="$vuetify.breakpoint.xsOnly"

        >
            <v-card>
                <v-row>
                    <v-col
                        v-for="visit in visits"
                        :key="visit.id"
                        @click="selectVisit(visit)"
                    >
                        <VisitViewComponent  :visit="visit" :nodisplay="true" />
                    </v-col>
                </v-row>
            </v-card>
        </v-dialog>

    </v-card>
</template>

<script lang="ts">
import {Vue, Component, Prop, Watch} from "vue-property-decorator"
import axios from "axios"
import { UserInterface } from "../../Types/User"
import VisitViewComponent from '../Visits/VisitViewComponent.vue'
import FacilityViewComponent from '../Facilities/FacilityViewComponent.vue'

@Component({
    components: {
        VisitViewComponent,
        FacilityViewComponent
    }
})
export default class BookingEditComponent extends Vue {
    @Prop() readonly booking!: any
    @Prop({default: false}) readonly new: boolean

    private selectVisitDialog = false;

    private visits = [];

    private get user(): UserInterface {
        return this.$store.state.user;
    }

    private get admin_data() {
        return this.$store.state.admin_data;
    }

    private selected_visit = null

    private free_schedules = [];

    private selected_booking_type = {name: "Professionnel", value: "appointmentHorse"}

    private bookings_type = [
        {name: "Installation", value: "facilityHorse"},
        {name: "Professionnel", value: "appointmentHorse"}
    ]

    private async selectVisit(visit: any) {
        this.selected_visit = visit;
        this.selectVisitDialog = false;

        await axios.get(`http://127.0.0.1:8000/api/appointments/${visit.id}/freeSchedules`, {
            headers: {
                'Authorization': 'Bearer ' + this.user.api_token
            }
        })
        .then((res: any) => this.free_schedules = res.data.success)
    }
    
    private loading = false;
    private facilities = []

    private booking_infos: any = {
       title: "",
       description: "",
       start_date: "",
       horse_id: 0
    }

    private formatDate(date: any): string {
        return date.toDateString();
    }

    private async save() {

        const date = this.booking_infos.start_date.split("T")[0]
        const time = this.booking_infos.start_date.split(".")[0].split("T")[1]

        this.booking_infos.start_date = date + ' ' + time;

        await axios.post(`http://localhost:8000/api/appointmentHorse/${this.selected_visit.id}/${this.booking_infos.horse_id}/store`, this.booking_infos, {
            headers: {
                'Authorization': 'Bearer ' + this.user.api_token
            }
        })
        .then(async(res: any) => {
            await axios.get(`http://localhost:8000/api/users/${this.user.id}/edit`, {
                headers: {
                    'Authorization': 'Bearer ' + this.user.api_token
                }
            }).then((res: any) => this.$store.commit('SET_USER', res.data.success))
        })

        this.$emit('done')
    }

    private async created() {
        await axios.get(`http://localhost:8000/api/appointments`, {
            headers: {
                'Authorization': 'Bearer ' + this.user.api_token
            }
        }).then((res: any) => {
            console.log(res)
            this.visits = res.data.success})

        await axios.get(`http://localhost:8000/api/facilities`, {
            headers: {
                'Authorization': 'Bearer ' + this.user.api_token
            }
        }).then((res: any) => {
            console.log(res)
            this.facilities = res.data.success})

        
    }
}
</script>

<style>

</style>