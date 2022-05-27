<template>
    <v-card>
        <v-card-title class="d-flex justify-space-between">
                <h2>Add Visit</h2>
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
                                v-model.number="visit_infos.duration"
                                label="Durée de chaque rendez-vous (minutes)"
                            ></v-text-field>
                        </v-col>

                        <v-col
                            cols="12"
                            md="4"
                        >
                            <v-text-field
                                v-model.number="visit_infos.max_appointments"
                                label="Nombre max de rendez-vous"
                            ></v-text-field>

                            <span>Durée totale de la visite : {{(visit_infos.duration * visit_infos.max_appointments) /60}}h</span>
                        </v-col>

                        <v-col
                            cols="12"
                            md="4"
                        >
                            
                            <span>Jour de la visite : </span>

                            <v-date-picker is-dark v-model="visit_infos.start_date" mode="date" label="Date de naissance" is24hr>
                                <template v-slot="{ inputValue, inputEvents }">
                                    <input
                                        class="px-2 py-1 border rounded focus:outline-none border:blue focus:border-blue-300 color:red"
                                        :value="inputValue"
                                        v-on="inputEvents"
                                        style="background-color:#bcbcbc"
                                    />
                                </template>
                            </v-date-picker>
                            
                        </v-col>

                        <v-col
                            cols="12"
                            md="4"
                        >
                           <v-select
                                v-model="selected_pro"
                                :items="admin_data.professionals"
                                item-text="firstname"
                                filled
                                outlined

                                return-object
                           >
                           </v-select>
                        </v-col>
                    </v-row>
                </v-container>
            </v-form>
        </v-card-text>

        <v-card-actions class="d-flex align-center">
            <v-btn color="red" @click="deleteVisit">Supprimer</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script lang="ts">
import {Vue, Component, Prop, Watch} from "vue-property-decorator"
import { ProfessionalInterface } from "../../Types/Professional"
import axios from "axios"
import { UserInterface } from "../../Types/User"
import { AppointmentInterface } from "../../Types/Appointment"

@Component
export default class VisitEditComponent extends Vue {
    @Prop() readonly visit!: AppointmentInterface
    @Prop({default: false}) readonly new: boolean

    private get user(): UserInterface {
        return this.$store.state.user;
    }

    private get admin_data() {
        return this.$store.state.admin_data;
    }

    private selected_pro: ProfessionalInterface = null
    
    private loading = false;

    private visit_infos: any = {
        duration: 0,
        start_date: "",
        max_appointments: 0,
        professional_id: 0
    }

    private formatDate(date: any): string {
        return date.toDateString();
    }

    private async deleteVisit() {
        await axios.post(`http://localhost:8000/api/appointments/${this.visit.id}/destroy`,{cancel_reason: 'Visite supprimée par l\'administrateur'}, {
            headers: {
                "Authorization" : "Bearer " + this.user.api_token
            }
        }).then( async(res: any) => {
            if(res.data.success) {
                await this.$store.dispatch('update', 'appointments');
                this.$emit('done');
            } else console.log(res)
        })
    }


    private async save() {
        this.visit_infos.professional_id = this.selected_pro.id

        

        if(this.new) {
            delete this.visit_infos.professional
            let {data} = await axios.post(`http://localhost:8000/api/appointments/store`, this.visit_infos, {
                headers: {
                    "Authorization" : "Bearer " + this.user.api_token
                }
            })

            if(data.success) {
                await this.$store.dispatch('update', 'appointments')
                this.$emit('done')
            } else {
                console.log(data)
            }
        } else {

            let {data} = await axios.put(`http://localhost:8000/api/appointments/${this.visit_infos.id}/update`, this.visit_infos, {
                headers: {
                    "Authorization" : "Bearer " + this.user.api_token
                }
            })

            if(data.success) {
                await this.$store.dispatch('update', 'appointments')
                this.$emit('done')
            } else {
                console.log(data)
            }

        }

    }

    private mounted() {
        if(!this.new) {
            this.visit_infos = JSON.parse(JSON.stringify(this.visit));

            this.selected_pro = this.visit.professional;
        }
    }
}
</script>

<style>

</style>