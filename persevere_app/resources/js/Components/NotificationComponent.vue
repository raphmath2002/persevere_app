<template>
    <div>
        <v-card dark class="notif d-flex justify-space-between align-center">
            <span @click="show = true">{{info.title}}</span>
            <v-icon @click="deleteNotif" color="red">mdi-delete</v-icon>
        </v-card>

        <v-dialog
            v-model="show"
            :fullscreen="$vuetify.breakpoint.xsOnly"
        >
            <v-card>
                <v-card-title class="d-flex justify-space-between">
                    <span>{{info.title}}</span>
                    <v-icon @click="show = false" color="red">mdi-close</v-icon>
                </v-card-title>

                <v-card-text>
                    <vue-simple-markdown :source="info.markdown"></vue-simple-markdown>
                </v-card-text>
                
                <v-divider></v-divider>

                <v-card-actions class="d-flex justify-center">
                    <v-btn @click="deleteNotif" color="red" style="font-weight: bold;">Supprimer</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script lang="ts">
import {Vue, Component, Prop} from "vue-property-decorator"
import Information, {InformationInterface} from "../Types/Information"
import axios from 'axios';
import { UserInterface } from "../Types/User";

@Component
export default class NotificationComponent extends Vue {
    @Prop({default: Information.emptyInformation()}) readonly info?: InformationInterface

    private get user(): UserInterface {
        return this.$store.state.user;
    }

    private show = false;

    private async deleteNotif() {
        this.show = false;
        let {data} = await axios.get(`http://localhost:8000/api/users/${this.user?.id}/advertisements/${this.info?.id}/read`, {
          headers: {
              'Authorization': 'Bearer ' + this.user?.api_token
        }
      });

      if(data.success) {
          await this.$store.dispatch("updateNotifs");
      }
    }
}

</script>

<style>
    .notif {
        padding: 5px 5px 5px 10px;
    }
</style>
