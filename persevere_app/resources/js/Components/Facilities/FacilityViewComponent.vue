<template>
    <v-container>
        <v-card  @click="viewOrEdit">
            <v-card-title>
                <h3>{{facility.name}}</h3>
            </v-card-title>

            <v-card-text>
                <div 
                   
                    class="pro-widget d-flex align-center"
                >

                </div>
            </v-card-text>
        </v-card>


        <v-dialog
            v-model="facilityDialog"
        >
            <!-- Réservation client facility -->
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
import {AppointmentInterface} from "../../Types/Appointment"
import { ProfessionalInterface } from "../../Types/Professional";
import FacilityEditComponent from "./FacilityEditComponent.vue"
import { FacilityInterface } from "../../Types/Facility";

@Component({
    components: {
        FacilityEditComponent
    }
})
export default class ProViewComponent extends Vue {
    @Prop() readonly facility!: FacilityInterface

    private editFacilityDialog = false;
    private facilityDialog = false;

    private get user(): UserInterface{
        return this.$store.state.user;
    }

    private viewOrEdit() {
        console.log("okay")
        if(this.user.auth_level == "customer") this.facilityDialog = true;
        else this.editFacilityDialog = true;
    }

    private mounted() {
        console.log(this.facility)
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