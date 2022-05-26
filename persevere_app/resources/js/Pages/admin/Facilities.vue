<template>
    <div class="facility-page">
        <v-container>
            <v-row>
                <v-col>
                    <div class="d-flex justify-space-between">
                        <h1>Installations</h1>
                        <v-icon @click="createFacilityDialog = true" size="50px" color="green">mdi-plus</v-icon>
                    </div>
                </v-col>
            </v-row>

            <v-row>
                <v-col>
                    <v-text-field
                        v-model="filter"
                        label="Filtre"
                        v-on:keyup="filterVisit"
                    >
                    </v-text-field>
                </v-col>
            </v-row>

            <v-row class="visits-list">
                <v-col cols="12" v-for="facility in allOrFilter()" :key="facility.id">
                    <FacilityViewComponent :facility="facility" />
                </v-col>
            </v-row>

            <v-dialog
                v-model="createFacilityDialog"
                :fullscreen="$vuetify.breakpoint.xsOnly"

            >
                <FacilityEditComponent @done="createFacilityDialog = false" :news="true"/>
            </v-dialog>
        </v-container>
    </div>
</template>

<script lang="ts">
import {Vue, Component} from "vue-property-decorator"
import FacilityEditComponent from "../../Components/Facilities/FacilityEditComponent.vue"
import FacilityViewComponent from "../../Components/Facilities/FacilityViewComponent.vue"

@Component({
    components: {
        FacilityEditComponent,
        FacilityViewComponent
    }
})
export default class Facilities extends Vue {

    private get admin_data() {
        return this.$store.state.admin_data;
    }

    private createFacilityDialog = false;

    private filtered_facility = []

    private filter = ""

    private filterVisit() {
        if(this.filter.length > 3) {
            this.filtered_facility = [];

            for(let facility of this.admin_data.facilities) {
                
                const string_user = JSON.stringify(facility).toLowerCase();
                const filter = this.filter.toLowerCase();
                if (string_user.includes(filter)) this.filtered_facility.push(facility)

            }
        }
    }

    private allOrFilter() {
        if(this.filter.length > 3) {
            return this.filtered_facility;
        } else return this.admin_data.facilities;
    }

    private mounted() {
        console.log(this.admin_data.facilities)
    }
}
</script>

<style>
    .facility-page {
        padding-bottom: 80px;
    }
</style>