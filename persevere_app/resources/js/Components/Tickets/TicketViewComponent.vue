<template>
    <v-container>
        <v-card @click="ticketDialog = true">
            <v-card-title>
                <h3>{{ticket.title}}</h3>
            </v-card-title>
        </v-card>


        <v-dialog
            v-model="ticketDialog"
        >

        </v-dialog>
    </v-container>
</template>

<script lang="ts">
import {Vue, Component, Prop} from "vue-property-decorator"
import { UserInterface } from "../../Types/User";
import { TicketInterface } from "../../Types/Ticket";

@Component
export default class TicketViewComponent extends Vue {
    @Prop() readonly ticket!: TicketInterface

    private ticketDialog = false;

    private get user(): UserInterface{
        return this.$store.state.user;
    }
}
</script>

<style>
    .profession-container {
        padding: 5px 5px 5px 20px;
    }

    .pro-avatar {
        border-radius: 50px;
    }
</style>