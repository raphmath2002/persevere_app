<template>
    <div class="pro-page">
        <v-container>
            <v-row>
                <v-col>
                    <div class="d-flex justify-space-between">
                        <h1>Professionels</h1>
                        <v-icon @click="createProDialog = true" size="50px" color="green">mdi-plus</v-icon>
                    </div>
                </v-col>
            </v-row>

            <v-row>
                <v-col>
                    <v-text-field
                        v-model="filter"
                        label="Filtre"
                        v-on:keyup="filterPro"
                    >
                    </v-text-field>
                </v-col>
            </v-row>

            <v-row class="pros-list">
                <v-col v-for="pro in allOrFilter()" :key="pro.id">
                    <ProViewComponent :professional="pro" />
                </v-col>
            </v-row>

            <v-dialog
                v-model="createProDialog"
                :fullscreen="$vuetify.breakpoint.xsOnly"

            >
                <ProEditComponent @done="createProDialog = false" :new="true" />
            </v-dialog>
        </v-container>
    </div>
</template>

<script lang="ts">
import {Vue, Component} from "vue-property-decorator"
import ProEditComponent from "../../Components/Professionals/ProEditComponent.vue"
import ProViewComponent from "../../Components/Professionals/ProViewComponent.vue"

@Component({
    components: {
        ProEditComponent,
        ProViewComponent
    }
})
export default class Professionals extends Vue {

    private get admin_data() {
        return this.$store.state.admin_data;
    }

    private createProDialog = false;

    private filtered_pros = []

    private filter = ""

    private filterPro() {
        if(this.filter.length > 3) {
            this.filtered_pros = [];

            for(let pro of this.admin_data.professionals) {
                
                const string_user = JSON.stringify(pro).toLowerCase();
                const filter = this.filter.toLowerCase();
                if (string_user.includes(filter)) this.filtered_pros.push(pro)

            }
        }
    }

    private allOrFilter() {
        if(this.filter.length > 3) {
            return this.filtered_pros;
        } else return this.admin_data.professionals;
    }
}
</script>

<style>
    .pro-page {
        padding-bottom: 80px;
    }
</style>