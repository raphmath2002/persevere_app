<template>
    <div class="visit-page">
        <v-container>
            <v-row>
                <v-col>
                    <div class="d-flex justify-space-between">
                        <h1>Pensions / Options</h1>
                        <v-icon @click="createPensionOptionDialog = true" size="50px" color="green">mdi-plus</v-icon>
                    </div>
                </v-col>
            </v-row>

            <v-row>
                <v-col>
                  <v-select
                    :items="items"
                    v-model="selected_item"
                    item-text="name"
                    filled
                    outlined
                    dense

                    return-object
                  >
                  </v-select>
                </v-col>
            </v-row>

            <v-row class="pensions-list" v-if="selected_item.value == 'pensions'">
                <v-col cols="12" v-for="pension in admin_data.pensions" :key="pension.id">
                    <PensionOptionViewComponent :item="pension" />
                </v-col>
            </v-row>

            <v-divider></v-divider>

            <v-row class="options-list" v-if="selected_item.value == 'options'">
                <v-col v-for="option in admin_data.options" :key="option.id">
                    <PensionOptionViewComponent :item="option" :type="selected_item" />
                </v-col>
            </v-row>

            <v-dialog
                v-model="createPensionOptionDialog"
                :fullscreen="$vuetify.breakpoint.xsOnly"

            >
                <PensionOptionEditComponent @done="createPensionOptionDialog = false" :news="true"/>
            </v-dialog>
        </v-container>
    </div>
</template>

<script lang="ts">
import {Vue, Component} from "vue-property-decorator"
import PensionOptionEditComponent from "../../Components/PensionsOptions/PensionOptionEditComponent.vue"
import PensionOptionViewComponent from "../../Components/PensionsOptions/PensionOptionViewComponent.vue"

@Component({
    components: {
        PensionOptionEditComponent,
        PensionOptionViewComponent
    }
})
export default class Visits extends Vue {

    private get admin_data() {
        return this.$store.state.admin_data;
    }

    private createPensionOptionDialog = false;

    private selected_item = {name: "Pension", value: "pensions"}

    private items = [
        {name: "Pension", value: "pensions"},
        {name: "Option", value: "options"}
    ]


}
</script>

<style>
    .visit-page {
        padding-bottom: 80px;
    }
</style>