
<template>
    <div class="tickets-page">
        <v-container>
            <v-row>
                <v-col>
                    <div class="d-flex justify-space-between">
                        <h1>Support</h1>
                        <v-icon v-if="user.auth_level == 'customer'" @click="createTicketDialog = true" size="50px" color="green">mdi-plus</v-icon>
                    </div>
                </v-col>
            </v-row>


            <v-row class="tickets-list">
                <v-col cols="12" xl="4" sm="4" v-for="ticket in tickets" :key="ticket.id">
                    <TicketViewComponent :ticket="ticket" />
                </v-col>
            </v-row>

            <v-dialog
                v-model="createTicketDialog"
                :fullscreen="$vuetify.breakpoint.xsOnly"

            >
                <TicketCreateComponent @done="createTicketDialog = false"/>
            </v-dialog>
        </v-container>
    </div>
</template>

<script lang="ts">
import {Vue, Component} from "vue-property-decorator"
import TicketCreateComponent from "../Components/Tickets/TicketCreateComponent.vue"
import TicketViewComponent from "../Components/Tickets/TicketViewComponent.vue"

@Component({
    components: {
        TicketCreateComponent,
        TicketViewComponent
    }
})
export default class Tickets extends Vue {

    private get user() {
        return this.$store.state.user;
    }

    private get tickets() {
        if(this.user.auth_level == "customer") return this.user.tickets;
        else return this.$store.state.admin_data.tickets;
    }

    private createTicketDialog = false;

    private mounted() {
        console.log(this.tickets)
    }
}
</script>

<style>
    .tickets-page {
        padding-bottom: 80px;
    }
</style>