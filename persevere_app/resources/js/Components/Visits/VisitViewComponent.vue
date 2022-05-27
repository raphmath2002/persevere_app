<template>
    <v-container>
        <v-card dark>
            <v-card-title>
                <span>{{visit.professional.name}}</span>  
                <span>{{visit.professional.firstname}}</span>
            </v-card-title>

            <v-card-text>
                <div 
                    @click="viewOrEdit"
                    class="pro-widget d-flex align-center flex-wrap justify-center"
                >
                    <v-img max-width="100px" height="100px" class="pro-avatar" :src="visit.professional.storage_path"></v-img>
                    
                    <div class="profession-container d-flex flex-column flex-wrap">
                        <span>{{visit.professional.profession}}</span>
                        <span>De {{visit.start_date}} à {{visit.end_date}}</span>
                    </div>
                </div>
            </v-card-text>
        </v-card>


        <v-dialog
            v-model="visitDialog"
        >

        </v-dialog>


        <v-dialog
            v-model="editVisitDialog"
            :fullscreen="$vuetify.breakpoint.xsOnly"

        >
            <ViewEditComponent @done="editVisitDialog = false" :visit="visit" />
        </v-dialog>
    </v-container>
</template>

<script lang="ts">
import {Vue, Component, Prop} from "vue-property-decorator"
import { UserInterface } from "../../Types/User";
import {AppointmentInterface} from "../../Types/Appointment"
import { ProfessionalInterface } from "../../Types/Professional";
import ViewEditComponent from './VisitEditComponent.vue'

@Component({
    components: {
        ViewEditComponent
    }
})
export default class VisitViewComponent extends Vue {
    @Prop() readonly visit!: AppointmentInterface
    @Prop({default: false}) nodisplay!: boolean


    private editVisitDialog = false;
    private visitDialog = false;

    private get user(): UserInterface{
        return this.$store.state.user;
    }

    private viewOrEdit() {
        if(this.nodisplay) return
        if(this.user.auth_level == "customer") this.visitDialog = true;
        else this.editVisitDialog = true;
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