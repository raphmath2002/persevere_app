<template>
    <v-card dense>
        <v-card-title class="d-flex justify-space-between">
                <h2>Add/Edit Pension/Option</h2>
                <div>
                    <v-progress-circular
                        v-if="loading"
                        indeterminate
                        color="red"
                    ></v-progress-circular>
                    <v-icon v-else color="green" size="50px" @click="save">mdi-content-save</v-icon>
                    <v-icon color="red" size="50px" @click="$emit('done')">mdi-close</v-icon>
                </div>
        </v-card-title>

        <v-card-text>
            <v-form>
                <v-container>
                    <v-row>
                         <v-select
                            v-if="news"
                            v-model="selected_item_type"
                            :items="item_types"
                            item-text="name"
                            filled
                            outlined
                            dense

                            return-object
                        >
                        </v-select>

                        <v-col
                            cols="12"
                            md="4"
                        >
                            <v-text-field
                                v-model.number="item_infos.name"
                                label="Nom"
                            ></v-text-field>
                        </v-col>

                        <v-col
                            cols="12"
                            md="4"
                        >
                            <v-textarea
                                v-model.number="item_infos.description"
                                label="Description"
                            ></v-textarea>
                        </v-col>

                     <v-col
                            cols="12"
                            md="4"
                        >
                            <v-text-field
                                v-model.number="item_infos.price"
                                label="Prix (€)"
                            ></v-text-field>
                        </v-col>

                        <v-col
                            cols="12"
                            md="4"
                            v-if="selected_item_type.value == 'options' || type.value == 'options'"
                        >
                           <v-select
                                v-model="item_infos.option_type"
                                :items="option_types"
                                item-text="name"
                                item-value="value"
                                filled
                                outlined
                                dense
                           >
                           </v-select>
                        </v-col>
                    </v-row>
                </v-container>
            </v-form>
        </v-card-text>
    </v-card>
</template>

<script lang="ts">
import {Vue, Component, Prop, Watch} from "vue-property-decorator"
import { ProfessionalInterface } from "../../Types/Professional"
import axios from "axios"
import { UserInterface } from "../../Types/User"
import { AppointmentInterface } from "../../Types/Appointment"

@Component
export default class PensionOptionEditComponent extends Vue {
    @Prop() readonly item!: any
    @Prop({default: false}) readonly news: boolean
    @Prop({default: () => {
        return {name: "", value: ""}
    }}) readonly type: {name: string, value: string}


    private get user(): UserInterface {
        return this.$store.state.user;
    }

    private get admin_data() {
        return this.$store.state.admin_data;
    }

    private selected_item_type = {name: "Pension", value: "pensions"}
    private selected_option_type =  {name: "Mensuelle", value: "mensual"}

    private item_types = [
        {name: "Pension", value: "pensions"},
        {name: "Option", value: "options"}
    ]

    private option_types = [
        {name: "Mensuelle", value: "mensual"},
        {name: "Ponctuelle", value: "ponctual"}
    ]


    
    private loading = false;

    private item_infos: any = {
       name: "",
       price: 0,
       description: "",
       option_type: "ponctual"
    }

    private formatDate(date: any): string {
        return date.toDateString();
    }


    private async save() {
        if(this.news) {
            let {data} = await axios.post(`http://localhost:8000/api/${this.selected_item_type.value}/store`, this.item_infos, {
                headers: {
                    "Authorization" : "Bearer " + this.user.api_token
                }
            })

            if(data.success) {
                await this.$store.dispatch('update', this.selected_item_type)
                this.$emit('done')
            } else {
                console.log(data)
            }
        } else {

            let {data} = await axios.put(`http://localhost:8000/api/${this.type.value}/${this.item.id}/update`, this.item_infos, {
                headers: {
                    "Authorization" : "Bearer " + this.user.api_token
                }
            })

            if(data.success) {
                await this.$store.dispatch('update', 'pensions')
                await this.$store.dispatch('update', 'options')
                this.$emit('done')
            } else {
                console.log(data)
            }

        }

    }

    private mounted() {
        if(!this.news) {
            this.item_infos = JSON.parse(JSON.stringify(this.item));
        }
    }
}
</script>

<style>

</style>