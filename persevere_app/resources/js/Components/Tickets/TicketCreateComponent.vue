<template>
    <v-card>
        <v-card-title class="d-flex justify-space-between">
                <h2>Créer un ticket</h2>
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
                                v-model.number="ticket_infos.title"
                                label="Raison du ticket"
                            ></v-text-field>
                        </v-col>

                         <v-col
                            cols="12"
                            md="4"
                        >
                            <v-textarea
                                v-model.number="first_message.content"
                                label="Message"
                            ></v-textarea>
                        </v-col>
                    </v-row>
                </v-container>
            </v-form>
        </v-card-text>

        <v-card-actions class="d-flex justify-center">
            <v-btn @click="save" color="primary">Envoyer</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script lang="ts">
import {Vue, Component, Prop, Watch} from "vue-property-decorator"
import { ProfessionalInterface } from "../../Types/Professional"
import axios from "axios"
import { UserInterface } from "../../Types/User"
import { AppointmentInterface } from "../../Types/Appointment"
import { MessageInterface } from "../../Types/Message"

@Component
export default class TicketCreateComponent extends Vue {

    private get user(): UserInterface {
        return this.$store.state.user;
    }

    private get admin_data() {
        return this.$store.state.admin_data;
    }

    private selected_pro: ProfessionalInterface = null
    
    private loading = false;

    private first_message: MessageInterface = {
        content: "",
        ticket_id: 0,
        user_id: this.user.id
    }

    private ticket_infos: any = {
        title: "",
        user_id: this.user.id,
    }

    private async save() {
        this.loading = true;
        await axios.post(`http://localhost:8000/api/tickets/store`, this.ticket_infos, {
                headers: {
                    "Authorization" : "Bearer " + this.user.api_token
                }
        }).then(async (res: any) => {
            if(res.data.success) {
                
                this.first_message.ticket_id = res.data.success.id;

                await axios.post(`http://localhost:8000/api/messages/store`, this.first_message, {
                        headers: {
                            "Authorization" : "Bearer " + this.user.api_token
                        }
                }).then( async (res: any) => {
                    if(res.data.success) {
                        await axios.get(`http://localhost:8000/api/tickets/user/${this.user.id}`, {
                                headers: {
                                    "Authorization" : "Bearer " + this.user.api_token
                                }
                        }).then((res: any) => {

                            if(res.data.success) {
                                console.log(res.data.success)
                                this.$store.commit('SET_USER_TICKETS', res.data.success);
                                this.$emit('done');
                            } else console.log(res.data)
                        })
                    }
                })

                

            } else console.log(res.data)

            this.loading = false;
        })
    }
}
</script>

<style>

</style>