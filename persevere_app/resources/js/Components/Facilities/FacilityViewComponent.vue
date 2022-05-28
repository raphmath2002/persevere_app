<template>
    <v-container>
        <v-card dark @click="viewOrEdit">
            <v-card-text>
                  <div class="facility-widget d-flex flex-wrap">
                    <v-img width="100px" :src="facility.facilities_images[0].storage_path"></v-img>
                    <div class="user-widget-infos d-flex flex-column justify-center align-center">
                        <span class="user-widget-name">{{facility.name}}</span>
                    </div>
                </div>
            </v-card-text>
        </v-card>


        <v-dialog
            v-model="facilityDialog"
            :fullscreen="$vuetify.breakpoint.xsOnly"
        >
            <v-card>
              <v-card-title class="d-flex justify-space-between">
                  <h3>Installation</h3>

                  <div>
                        <v-icon @click="save" color="green" size="50px">mdi-content-save</v-icon>
                        <v-icon @click="facilityDialog = false" color="red" size="50px">mdi-close</v-icon>
                  </div>
              </v-card-title>

              <v-card-text>
                  <v-row>
                        <v-col cols="12">
                                <v-select
                                    v-model.number="selected_horse"
                                    :items="user.horses"
                                    item-text="name"
                                    label="Pour qui ?"

                                    item-value="id"
                                ></v-select>
                        </v-col>

                            <v-col cols="12" class="d-flex align-center">
                               <v-date-picker
                                    v-model="selected_date"
                                    :value="null"
                                    color="red"
                                    is-dark
                                    :min-date="today"
                                />
                            </v-col>
                        <v-col cols="12" class="d-flex justify-space-between">
                            <v-col cols="4">
                                <v-text-field
                                    v-model="day_facility_infos.start"
                                    dense
                                    label="De"
                                    v-on:keyup="checkFrom"
                                ></v-text-field>
                            </v-col>
                                <v-col cols="4">
                                    <v-text-field
                                        v-model="day_facility_infos.end"
                                        dense
                                        label="à"
                                        v-on:keyup="checkTo"
                                    ></v-text-field>
                            </v-col>
                        </v-col>

                        <v-col v-if="facility.exceptions.length > 0">
                            <h3>Indisponnibilités exceptionnelles</h3>
                            <div class="exception" v-for="exception in facility.exceptions" :key="exception.id">
                                <span>ATTENTION : cette installation ne sera pas disponnible du</span>
                                <span>{{formatDate(exception.start_date)}} au {{formatDate(exception.end_date)}}</span>
                            </div>
                        </v-col>

                      <v-col cols="12">
                            <h3>Disponibilités</h3>
                            <v-col v-for="day_facility in day_facility_list" :key="day_facility.id">
                                <v-card
                                    dark
                                >
                                    <v-card-title>
                                        {{day_facility.day}}
                                    </v-card-title>

                                    <v-card-text class="d-flex flex-column">
                                        <div v-for="dispo in day_facility.dispos" :key="JSON.stringify(dispo)">
                                            <span>De {{dispo.start_hour}}h{{dispo.start_minute}} à {{dispo.end_hour}}h{{dispo.end_minute}}</span>
                                        </div>
                                    </v-card-text>
                                </v-card>
                            </v-col>
                      </v-col>
                  </v-row>
              </v-card-text>
            </v-card>

             <v-snackbar
                v-model="displayAlert"
                :timeout="3000"
                color="red"
            >
            {{ errorMessage}}

                <template v-slot:action="{ attrs }">
                    <v-btn
                        color="black"
                        text
                        v-bind="attrs"
                        @click="displayAlert = false"
                    >
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </template>
            </v-snackbar>
        </v-dialog>

        <v-dialog
            v-model="editFacilityDialog"
            :fullscreen="$vuetify.breakpoint.xsOnly"
        >
            <FacilityEditComponent @done="editFacilityDialog = false" :facility="facility" />
        </v-dialog>
    </v-container>
</template>

<script lang="ts">
import {Vue, Component, Prop} from "vue-property-decorator"
import { UserInterface } from "../../Types/User";
import FacilityEditComponent from "./FacilityEditComponent.vue"
import { FacilityInterface } from "../../Types/Facility";

import axios from "axios"

@Component({
    components: {
        FacilityEditComponent
    }
})
export default class FacilityViewComponent extends Vue {
    @Prop() readonly facility!: any
    @Prop({default: false}) readonly nodisplay!: boolean 

    private editFacilityDialog = false;
    private facilityDialog = false;

    private get user(): UserInterface{
        return this.$store.state.user;
    }
    private selected_day: {id: number, name: string} = null

    private today = new Date()

    private errorMessage = ""
    private displayAlert = false

    private selected_horse = 0

    private viewOrEdit() {
        if(this.nodisplay) return
        if(this.user.auth_level == "customer") this.facilityDialog = true;
        else this.editFacilityDialog = true;
    }

    private async mounted() {
        await this.getDispos();
    }

    private days: {id: number, name: string}[] = []


    private async save() {
        let date = new Date(this.selected_date).toJSON().split('T')[0]
        
        let from = `${date} ${this.day_facility_infos.start}:00`
        let to = `${date} ${this.day_facility_infos.end}:00`


        await axios.post(`http://localhost:8000/api/facilityHorse/${this.facility.id}/${this.selected_horse}/store`, {start_date: from, end_date: to}, {
            headers: {
                'Authorization': 'Bearer ' + this.user.api_token
            }
        })
        .then((res: any) => {
            if(res.data.error) {
                this.errorMessage = res.data.error
                this.displayAlert = true;
            } else {
                this.facilityDialog = false;
                this.$emit('done')
            }
        })  
    }

    private addDayFacility () {

    }

    private checkTo() {
        const value: string = this.day_facility_infos.end;

        if(value.length == 2) {
            this.day_facility_infos.end += ":"
        }

        if(value.length >= 3) {
            let new_h = value.split(':')[0]
            let new_m = value.split(':')[1]

            if(Number.parseInt(new_h) > 23) new_h = "23"
            if(Number.parseInt(new_m) > 59) new_m = "59"

            if(!new_m) new_m = ""
            if(!new_h) new_h = ""


            this.day_facility_infos.end = `${new_h}:${new_m}`;
        }

    }

    private checkFrom() {
        
        const value: string = this.day_facility_infos.start;

        if(value.length == 2) {
            this.day_facility_infos.start += ":"
        }

        if(value.length >= 3) {
            let new_h = value.split(':')[0]
            let new_m = value.split(':')[1]

            if(Number.parseInt(new_h) > 23) new_h = "23"
            if(Number.parseInt(new_m) > 59) new_m = "59"

            if(!new_m) new_m = ""
            if(!new_h) new_h = ""

            this.day_facility_infos.start = `${new_h}:${new_m}`;
        }

    }


    private day_facility_infos = {
        start: "",
        end: ""
    }

    private selected_date = new Date()

    private day_facility_list = []


    private async getDispos() {
        for (const day of this.facility.days) {
            const day_facility = this.day_facility_list.find((x: any) => x.day == day.name);

            if(!day_facility) {
                console.log("push")
                this.day_facility_list.push({
                    id: day.pivot.id,
                    day: day.name,
                    dispos: [
                        {start_hour: day.pivot.start_hour, start_minute: day.pivot.start_minute,
                        end_hour: day.pivot.end_hour, end_minute: day.pivot.end_minute}
                    ]
                })
            } else {
                const index = this.day_facility_list.indexOf(day_facility)

                if(this.day_facility_list[index].dispos.length < 2) {
                    this.day_facility_list[index].dispos.push(
                        {start_hour: day.pivot.start_hour, start_minute: day.pivot.start_minute,
                        end_hour: day.pivot.end_hour, end_minute: day.pivot.end_minute}
                    )
                }
            }
        }

        await axios.get(`http://localhost:8000/api/days`, {headers: {
            'Authorization': 'Bearer ' + this.user.api_token
        }}).then((res:any) => {
            if(res.data.success) {
                this.days = res.data.success;
            } else console.log(res)
        })
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
}
</script>

<style scoped>
    .profession-container {
        padding: 5px 5px 5px 20px;
    }

    .exception {
        padding: 10px;

        background-color: rgb(255, 121, 121);
        font-weight: bold;
        border-radius: 20px;
        margin: 15px 0 15px 0;

        text-align: center;
    }

    .exception span {
        color: black;
    }
</style>