<template>
    <v-container>
        <v-card dark dense @click="ticketDialog = true">
            <v-card-title>
                <h3>{{ticket.title}}</h3>
            </v-card-title>
        </v-card>


        <v-dialog
            :fullscreen="$vuetify.breakpoint.xsOnly"
            v-model="ticketDialog"
        >
            <v-card>
                <v-card-title class="d-flex justify-space-between">
                       <h2>Ticket</h2>
                       <v-icon color="red" size="50px" @click="ticketDialog = false">mdi-close</v-icon>
                </v-card-title>

                <v-card-text>
                    <div class="chatbox-container">
                        <div class="chatbox-messages-container">
                            
                        </div>

                        <div class="chatbox-input-container">

                        </div>
                    </div>
                </v-card-text>
            </v-card>
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

    .chatbox-container {
        border: solid red 1px;
        height: 100%;
    }

    .chatbox-input-container {
        border: solid blue 1px;
    }
</style>