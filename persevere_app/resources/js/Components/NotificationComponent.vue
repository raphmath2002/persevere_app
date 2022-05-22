<template>
    <div>
        <div class="d-flex justify-space-between align-center">
            <span @click="show = true">{{info.title}}</span>
            <v-icon @click="deleteNotif" color="red">mdi-delete</v-icon>
        </div>

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

@Component
export default class NotificationComponent extends Vue {
    @Prop({default: Information.emptyInformation()}) readonly info?: InformationInterface

    private show = false;

    private deleteNotif() {

    }
}

</script>
