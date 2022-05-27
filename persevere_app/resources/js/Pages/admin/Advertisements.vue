<template>
    <div class="visit-page">
        <v-container>
            <v-row>
                <v-col>
                    <div class="d-flex justify-space-between">
                        <h1>Annonces</h1>
                        <v-icon @click="createAdvertDialog = true" size="50px" color="green">mdi-plus</v-icon>
                    </div>
                </v-col>
            </v-row>

            <v-row class="adverts-list">
                <v-col cols="12" v-for="advert in admin_data.advertisements" :key="advert.id">
                    <AdvertisementViewComponent :advert="advert" />
                </v-col>
            </v-row>

            <v-dialog
                v-model="createAdvertDialog"
                :fullscreen="$vuetify.breakpoint.xsOnly"

            >
                <AdvertisementEditComponent @done="createAdvertDialog = false" />
            </v-dialog>
        </v-container>
    </div>
</template>

<script lang="ts">
import {Vue, Component} from "vue-property-decorator"
import AdvertisementEditComponent from "../../Components/Advertisements/AdvertisementEditComponent.vue"
import AdvertisementViewComponent from "../../Components/Advertisements/AdvertisementViewComponent.vue"

@Component({
    components: {
        AdvertisementEditComponent,
        AdvertisementViewComponent
    }
})
export default class Visits extends Vue {

    private get admin_data() {
        return this.$store.state.admin_data;
    }

    private createAdvertDialog = false;


}
</script>

<style>
    .visit-page {
        padding-bottom: 80px;
    }
</style>