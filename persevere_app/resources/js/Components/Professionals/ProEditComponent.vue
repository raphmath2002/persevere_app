<template>
    <v-card>
        <v-card-title class="d-flex justify-space-between">
                <h2>Add/Edit Pro</h2>
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

            <v-row>
                <v-col class="avatar-container d-flex justify-center" @click="$refs.file.click()">
                    <v-img width="100px" height="100px" v-if="professional_infos.storage_path.length > 0" class="pro-details-avatar" :src="professional_infos.storage_path"></v-img>
                    <div v-else class="pro-details-avatar no-avatar"></div>
                    <input ref="file" id="avatar-file" type="file" name="name" style="display: none;" v-on:change="insertAvatar" />
                </v-col>
            </v-row>
            

            <v-form>
                <v-container>
                    <v-row>
                         <v-col
                            cols="12"
                            md="4"
                        >
                            <v-text-field
                                v-model="professional_infos.name"
                                label="Nom"
                            ></v-text-field>
                        </v-col>

                         <v-col
                            cols="12"
                            md="4"
                        >
                            <v-text-field
                                v-model="professional_infos.firstname"
                                label="Prénom"
                            ></v-text-field>
                        </v-col>

                         <v-col
                            cols="12"
                            md="4"
                        >
                            <v-text-field
                                v-model="professional_infos.email"
                                label="Adresse email"
                            ></v-text-field>
                        </v-col>

                         <v-col
                            cols="12"
                            md="4"
                        >
                            <v-text-field
                                v-model="professional_infos.phone"
                                label="Téléphone"
                            ></v-text-field>
                        </v-col>

                         <v-col
                            cols="12"
                            md="4"
                        >
                            <v-text-field
                                v-model="professional_infos.profession"
                                label="Profession"
                            ></v-text-field>
                        </v-col>

                        <v-col
                            cols="12"
                            md="4"
                        >
                            <v-text-field
                                v-model="professional_infos.postal_code"
                                label="Code postal"
                            ></v-text-field>
                        </v-col>

                        <v-col
                            cols="12"
                            md="4"
                        >
                            <v-text-field
                                v-model="professional_infos.postal_address"
                                label="Adresse"
                            ></v-text-field>
                        </v-col>

                        <v-col
                            cols="12"
                            md="4"
                        >
                            <v-text-field
                                v-model="professional_infos.city"
                                label="Ville"
                            ></v-text-field>
                        </v-col>

                        <v-col
                            cols="12"
                            md="4"
                        >
                            <v-text-field
                                v-model="professional_infos.country"
                                label="Pays"
                            ></v-text-field>
                        </v-col>

                        <v-col
                            cols="12"
                            md="4"
                        >
                            
                            <span>Date de naissance : </span>

                            <v-date-picker is-dark v-model="professional_infos.birth_date" mode="date" label="Date de naissance" is24hr>
                                <template v-slot="{ inputValue, inputEvents }">
                                    <input
                                        class="px-2 py-1 border rounded focus:outline-none border:blue focus:border-blue-300 color:red"
                                        :value="inputValue"
                                        v-on="inputEvents"
                                        style="background-color:#bcbcbc"
                                    />
                                </template>
                            </v-date-picker>
                            
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

@Component
export default class ProEditComponent extends Vue {
    @Prop() readonly professional!: ProfessionalInterface
    @Prop({default: false}) readonly new: boolean

    private get user(): UserInterface {
        return this.$store.state.user;
    }
    
    private loading = false;

    private professional_infos: any = {
        name: "",
        firstname: "",
        email: "",
        phone: "", 
        profession: "",
        postal_code: "",
        postal_address: "",
        city: "",
        country: "",
        birth_date: "",
        storage_path: "",
    }

    private formatDate(date: any): string {
        return date.toDateString();
    }

    private async insertAvatar(event: any) {
        let reader = new FileReader();

        reader.onloadend = async (evt: any) => {
            if(evt.target.readyState == FileReader.DONE) {
                this.professional_infos.storage_path = reader.result as string
            }
        }
        await reader.readAsDataURL(event.target.files[0])
    }


    private async save() {
        //console.log(this.professional_infos)
        //this.professional_infos.birth_date = this.formatDate(this.professional_infos.birth_date)
        if(this.new) {

            let {data} = await axios.post(`http://localhost:8000/api/professionals/store`, this.professional_infos, {
                headers: {
                    "Authorization" : "Bearer " + this.user.api_token
                }
            })

            if(data.success) {
                await this.$store.dispatch('update', 'professionals')
                this.$emit('done')
            } else {
                console.log(data)
            }
        } else {
             let {data} = await axios.put(`http://localhost:8000/api/professionals/${this.professional_infos.id}/update`, this.professional_infos, {
                headers: {
                    "Authorization" : "Bearer " + this.user.api_token
                }
            })

            if(data.success) {
                await this.$store.dispatch('update', 'professionals')
                this.$emit('done')
            } else {
                console.log(data)
            }
        }
    }

    private mounted() {
        if(!this.new) this.professional_infos = JSON.parse(JSON.stringify(this.professional));
    }
}
</script>

<style>
    .pro-details-avatar {
        width: 100px;
        height: 100px;

        border-radius: 100px;
    }

    .pro-details-avatar.no-avatar {
       border: solid black 1px;
    }
</style>