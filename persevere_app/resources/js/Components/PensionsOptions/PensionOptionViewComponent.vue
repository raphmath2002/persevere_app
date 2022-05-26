<template>
    <v-container>
        <v-card
            @click="viewOrEdit"
        >
            <v-card-title>
                <h3>{{item.name}}</h3>
            </v-card-title>

            <v-card-text>
                <div 
                    
                    class="pro-widget d-flex align-center"
                >
                   
                </div>
            </v-card-text>
        </v-card>


        <v-dialog
            v-model="pensionOptionDialog"
        >

        </v-dialog>


        <v-dialog
            v-model="editPensionOptionDialog"
            :fullscreen="$vuetify.breakpoint.xsOnly"

        >
            <PensionOptionEditComponent @done="editPensionOptionDialog = false" :item="item" :type="type" />
        </v-dialog>
    </v-container>
</template>

<script lang="ts">
import {Vue, Component, Prop} from "vue-property-decorator"
import { UserInterface } from "../../Types/User";
import {AppointmentInterface} from "../../Types/Appointment"
import { ProfessionalInterface } from "../../Types/Professional";
import PensionOptionEditComponent from './PensionOptionEditComponent.vue'

@Component({
    components: {
        PensionOptionEditComponent
    }
})
export default class PensionOptionViewComponent extends Vue {
    @Prop() readonly item!: any
    @Prop() readonly type!: any

    private editPensionOptionDialog = false;
    private pensionOptionDialog = false;

    private get user(): UserInterface{
        return this.$store.state.user;
    }

    private viewOrEdit() {
        if(this.user.auth_level == "customer") this.pensionOptionDialog = true;
        else this.editPensionOptionDialog = true;
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