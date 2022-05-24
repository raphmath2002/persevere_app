<template>
    <div class="visit-page">
        <v-container>
            <v-row>
                <v-col>
                    <div class="d-flex justify-space-between">
                        <h1>Visites</h1>
                        <v-icon @click="createVisitDialog = true" size="50px" color="green">mdi-plus</v-icon>
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
                <v-col v-for="visit in allOrFilter()" :key="visit.id">
                    <VisitViewComponent :visit="visit" />
                </v-col>
            </v-row>

            <v-dialog
                v-model="createVisitDialog"
                :fullscreen="$vuetify.breakpoint.xsOnly"

            >
                <VisitEditComponent @done="createVisitDialog = false" :new="true"/>
            </v-dialog>
        </v-container>
    </div>
</template>

<script lang="ts">
import {Vue, Component} from "vue-property-decorator"
import VisitEditComponent from "../../Components/Visits/VisitEditComponent.vue"
import VisitViewComponent from "../../Components/Visits/VisitViewComponent.vue"

@Component({
    components: {
        VisitEditComponent,
        VisitViewComponent
    }
})
export default class Visits extends Vue {

    private get admin_data() {
        return this.$store.state.admin_data;
    }

    private createVisitDialog = false;

    private filtered_visits = []

    private filter = ""

    private filterVisit() {
        if(this.filter.length > 3) {
            this.filtered_visits = [];

            for(let visit of this.admin_data.appointments) {
                
                const string_user = JSON.stringify(visit).toLowerCase();
                const filter = this.filter.toLowerCase();
                if (string_user.includes(filter)) this.filtered_visits.push(visit)

            }
        }
    }

    private allOrFilter() {
        if(this.filter.length > 3) {
            return this.filtered_visits;
        } else return this.admin_data.appointments;
    }
}
</script>

<style>
    .visit-page {
        padding-bottom: 80px;
    }
</style>