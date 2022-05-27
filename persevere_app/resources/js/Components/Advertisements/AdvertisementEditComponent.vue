<template>
    <v-card>
        <v-card-title class="d-flex justify-space-between">
                <h3>Poster une annonce</h3>
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
                         <v-col
                            cols="12"
                            md="4"
                        >
                            <v-text-field
                                v-model="advert_infos.title"
                                label="Titre"
                                filled
                                outlined
                                dense
                            ></v-text-field>
                        </v-col>

                        <v-col
                            cols="12"
                            md="4"
                        >
                            <v-textarea
                                v-model="advert_infos.markdown"
                                label="Annonce (MarkDown)"
                                filled
                                outlined
                                dense
                            ></v-textarea>
                        </v-col>

                        <v-col
                            cols="12"
                            md="4"
                        >
                            <v-switch
                            v-model="withException"
                            label="Inclure une fermeture d'installation ?"
                            ></v-switch>
                        </v-col>
                    </v-row>

                    <v-row v-if="withException">
                        <v-col v-if="!selected_facility">
                            <v-btn dense color="primary" @click="selectFacilityDialog = true">Selectionner une installation</v-btn>
                        </v-col>
                        <v-col v-else cols="12">
                            <v-row>
                                 <v-col cols="10">
                                    <FacilityViewComponent :facility="selected_facility" />
                                </v-col>
                                <v-col cols="2" class="d-flex align-center">
                                    <v-icon size="50px" color="primary" @click="selectFacilityDialog = true">mdi-swap-horizontal</v-icon>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col cols="12">
                                    <v-date-picker
                                        :min-date="today"
                                        v-model="exceptionRange"
                                        color="red"
                                        is-dark
                                        is-range
                                        mode="datetime"
                                    />
                                </v-col>
                            </v-row>
                        </v-col>
                    </v-row>
                </v-container>
            </v-form>
        </v-card-text>

        <v-dialog
            :fullscreen="$vuetify.breakpoint.xsOnly"
            v-model="selectFacilityDialog"
        >
            <v-card>
                <v-row>
                    <v-col @click="selectFacility(facility)" v-for="facility in admin_data.facilities" :key="facility.id">
                        <FacilityViewComponent  :facility="facility" :nodisplay="true" />
                    </v-col>
                </v-row>
            </v-card>
        </v-dialog>
    </v-card>
</template>

<script lang="ts">
import {Vue, Component, Prop, Watch} from "vue-property-decorator"
import { ProfessionalInterface } from "../../Types/Professional"
import axios from "axios"
import { UserInterface } from "../../Types/User"
import { AppointmentInterface } from "../../Types/Appointment"
import { FacilityInterface } from "../../Types/Facility"
import FacilityViewComponent from '../Facilities/FacilityViewComponent.vue'

@Component({
    components: {
        FacilityViewComponent
    }
})
export default class AdvertisementEditComponent extends Vue {
    @Prop() readonly advert!: any

    private get user(): UserInterface {
        return this.$store.state.user;
    }

    private test() {
        console.log(this.exceptionRange)
    }

    private exceptionRange = {
        start: new Date(),
        end: new Date()
    }

    private selectFacilityDialog = false;

    private get admin_data() {
        return this.$store.state.admin_data;
    }

    private selectFacility(facility: FacilityInterface) {
        this.selected_facility = facility;
        this.selectFacilityDialog = false;
    }

    private selected_facility: FacilityInterface = null
    private withException = false;
    
    private loading = false;

    private advert_infos: any = {
       title: "",
       markdown: ""
    }

    private exception_infos: any = {
        start_date: "",
        end_date: ""
    }

    private formatDate(date: any): string {
        return date.toDateString();
    }


    private async save() {

        const headers = {
            headers: {
                'Authorization': 'Bearer '+ this.user.api_token
            }
        }

        await axios.post(`http://localhost:8000/api/advertisements/store`, this.advert_infos, headers)
        .then(async (res: any) => {
            if(res.data.success) {
                if(this.withException) {
                    let startDate = new Date(this.exceptionRange.start.setHours(this.exceptionRange.start.getHours() + 2)).toJSON()
                    startDate = `${startDate.split('T')[0]} ${startDate.split('T')[1].replace('Z', '').split('.')[0]}`

                    let endDate =  new Date(this.exceptionRange.end.setHours(this.exceptionRange.end.getHours() + 2)).toJSON()
                    endDate = `${endDate.split('T')[0]} ${endDate.split('T')[1].replace('Z', '').split('.')[0]}`

                    await axios.post(`http://localhost:8000/api/exceptions/${this.selected_facility.id}/store`, {
                        title: this.advert_infos.title,
                        start_date: startDate,
                        end_date: endDate
                    }, headers)
                    .then((res:any) => {
                        console.log(res);
                    })
                }

                await this.$store.dispatch('update', 'advertisements');
                this.$emit('done')
            } else console.log(res)
        })
    }

    private get today() {
        return new Date()
    }

    private mounted() {

    }
}
</script>

<style>

</style>