<template>
    <div>
        <v-card class="ticket d-flex justify-space-between" dark dense @click="ticketDialog = true">
            <span>{{ticket.title}}</span>
            <v-icon>mdi-arrow-right-thick</v-icon>
        </v-card>


        <v-dialog
            :fullscreen="$vuetify.breakpoint.xsOnly"
            v-model="ticketDialog"
        >
            <v-card>
                <v-card-title class="d-flex justify-space-between">
                       <h2>Ticket</h2>
                       <div>
                           <v-progress-circular
                            v-if="loading"
                            indeterminate
                            color="red"
                        ></v-progress-circular>
                       <v-icon color="red" size="50px" @click="ticketDialog = false">mdi-close</v-icon>

                       </div>

                </v-card-title>

                <v-card-text>
                    <div class="chatbox-container">
                        <div class="messages-container d-flex flex-column">
                            <div :class="`message d-flex flex-column align-self-${message.align}`" :style="`background-color: ${message.bg_color}`" v-for="message in messages" :key="message.id">
                                <span class="message-from">{{message.from}}</span>
                                <p class="message-text" :style="`text-align: ${message.align};`">{{message.content}}</p>
                                <span class="message-at" :style="`text-align: ${message.align};`">{{formatDate(message.created_at)}}</span>
                            </div>
                        </div>
                    </div>
                </v-card-text>
            </v-card>

            <div class="chatbox-input-container d-flex">
                <v-textarea 
                    v-model="message"
                    auto-grow 
                    counter
                    dense outlined 
                    filled 
                    class="input">
                </v-textarea>

                <v-icon @click="send" class="send-icon" color="green" size="30px">mdi-send</v-icon>
            </div>
        </v-dialog>
    </div>
</template>

<script lang="ts">
import {Vue, Component, Prop} from "vue-property-decorator"
import { UserInterface } from "../../Types/User";
import { TicketInterface } from "../../Types/Ticket";
import { MessageInterface } from "../../Types/Message";
import axios from 'axios'

@Component
export default class TicketViewComponent extends Vue {
    @Prop() readonly ticket!: TicketInterface

    private ticketDialog = false;

    private loading = false;

    private get user(): UserInterface{
        return this.$store.state.user;
    }

    private formatDate(_date: string) {
        const date = new Date(_date)
        return new Intl.DateTimeFormat('fr-FR').format(date)
    }

    private message = ""

    private get messages() {
        let messages = []

        for (const message of this.ticket?.messages as MessageInterface[]) {

            let fromSelf = message.user_id == this.user.id

            messages.push(
                {
                    id: message.id,
                    content: message.content,
                    created_at: message.created_at,
                    self: fromSelf ? true : false,
                    align: fromSelf ? 'end' : 'start',
                    bg_color: fromSelf ? '#efedff' : '#e5e5e5',
                    from: fromSelf ? 'Vous' : 'Destinataire'
                }
            )
        }

        return messages
    }

    private async send() {
        if(this.message.length > 0) {

            

            this.loading = true;
            const newMessage = {
                content: this.message,
                ticket_id: this.ticket.id,
                user_id: this.user.id
            }
            
            await axios.post(`http://localhost:8000/api/messages/store`, newMessage, {headers: {
                'Authorization': 'Bearer ' + this.user.api_token
            }}).then(async (res: any) => {
                if(res.data.success) {
                    await axios.get(`http://localhost:8000/api/tickets/user/${this.user.id}`, {
                            headers: {
                                "Authorization" : "Bearer " + this.user.api_token
                            }
                    }).then((res: any) => {

                        if(res.data.success) {
                            if(this.user.auth_level == "customer") this.$store.commit('SET_USER_TICKETS', res.data.success);
                            else this.$store.dispatch('update', 'tickets');
                            
                            let chatbox = document.querySelector('.chatbox-container')

                            chatbox.scroll({top: chatbox.scrollHeight})
                        } else console.log(res.data)
                    })
                }
            })
            this.message = ""
            this.loading = false;
        }
    }
}
</script>

<style>
    .ticket {
        padding: 5px 5px 5px 10px;
    }

    .message {
        padding: 10px;
        width: 50%;
        border-radius: 20px;
        margin: 10px 0 10px 0;

        border: solid black .1px;
    }

    .chatbox-container {
        height: 60%;
        overflow: auto;
        padding-bottom: 150px;
    }

    .chatbox-input-container {
        position: fixed;
        bottom: 0;

        padding: 10px 20px 0 20px;
        background-color: white;
    }

    .message-from {
        color: black;
        font-weight: bold;
    }

    .message-text{
        color: black;
    }

    .message_at {
        font-style: italic;
    }

    .input {
        width: 100%;
    }

    .send-icon {
        padding: 0 0 0 10px;
    }
</style>