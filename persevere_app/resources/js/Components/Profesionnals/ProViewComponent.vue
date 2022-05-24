<template>
    <v-container>
        <v-card>
            <v-card-title>
                <h3>{{profesionnal.name}} {{profesionnal.firstname}}</h3>
            </v-card-title>

            <v-card-text>
                <div 
                    @click="viewOrEdit"
                    class="pro-widget d-flex align-center"
                >
                    <v-img max-width="100px" height="100px" class="pro-avatar" :src="profesionnal.storage_path"></v-img>
                    
                    <div class="profession-container">
                        <span>{{profesionnal.profession}}</span>
                    </div>
                </div>
            </v-card-text>
        </v-card>


        <v-dialog
            v-model="proDialog"
        >

        </v-dialog>


        <v-dialog
            v-model="editProDialog"
            :fullscreen="$vuetify.breakpoint.xsOnly"

        >
            <ProEditComponent @done="editProDialog = false" :profesionnal="profesionnal" />
        </v-dialog>
    </v-container>
</template>

<script lang="ts">
import {Vue, Component, Prop} from "vue-property-decorator"
import { UserInterface } from "../../Types/User";
import {AppointmentInterface} from "../../Types/Appointment"
import { ProfessionalInterface } from "../../Types/Professional";
import ProEditComponent from "./ProEditComponent.vue"

@Component({
    components: {
        ProEditComponent
    }
})
export default class ProViewComponent extends Vue {
    @Prop() readonly profesionnal!: ProfessionalInterface

    private editProDialog = false;
    private proDialog = false;

    private get user(): UserInterface{
        return this.$store.state.user;
    }

    private viewOrEdit() {
        if(this.user.auth_level == "customer") this.proDialog = true;
        else this.editProDialog = true;
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