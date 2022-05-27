<template>
    <v-container>
        <v-row>
            <v-col>
                <div class="d-flex justify-space-between">
                    <h1>Chevaux</h1>
                    <v-icon @click="editHorse()" size="50px" color="green">mdi-plus</v-icon>
                </div>
            </v-col>
        </v-row>

        
        <v-row>
            <v-col>
                <v-text-field
                    v-model="filter"
                    label="Filtre"
                    v-on:keyup="filterHorses"
                >
                </v-text-field>
            </v-col>
        </v-row>

         <v-row class="horses-list">
            <v-col v-for="horse in allOrFilter()" :key="horse.id">
                <div 
                    @click="editHorse(horse)"
                    class="horse-widget d-flex justify-space-between"
                    :style="`border-color:${sexIcon(horse).color}; background:${horse.sex != 'male' ? 'rgb(255, 0, 255, .1)' : 'rgb(0, 0, 255, .1)'}`"
                >
                    <v-img class="horse-avatar" :src="horse.storage_path"></v-img>
                    <div class="horse-details d-flex flex-column justify-center">
                        <span class="horse-name">{{horse.name}}</span>
                        <span class="horse-added-at">{{horse.user.name}} {{horse.user.firstname}}</span>
                    </div>

                    <div class="sex-container">
                        <div class="sex-icon-container">
                            <v-icon :color="sexIcon(horse).color">{{sexIcon(horse).icon}}</v-icon>
                        </div>
                    </div>
                </div>
            </v-col>
        </v-row>

        <v-dialog
            v-model="createHorseDialog"
            :fullscreen="$vuetify.breakpoint.xsOnly"
        >
            <v-card>
                <v-card-title class="d-flex justify-space-between">
                    <h2>Add/Edit cheval</h2>
                    <div>
                        <v-progress-circular
                            v-if="loading"
                            indeterminate
                            color="red"
                        ></v-progress-circular>
                        <v-icon v-else color="green" size="50px" @click="save">mdi-content-save</v-icon>
                        <v-icon color="red" size="50px" @click="createHorseDialog = false">mdi-close</v-icon>
                    </div>
                </v-card-title>
                <v-card-text>

                    <v-select
                        v-model="selected_section"
                        :items="horse_sections"
                        outlined
                        dense
                    ></v-select>

                    <v-container>
                        <div class="informations-edit section" v-if="selected_section == 'Informations'">
                            <v-form>
                                <v-container>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <div class="avatar-edit-container">
                                            <v-img class="horse-avatar" :src="selected_horse.storage_path"></v-img>
                                            <v-btn @click="$refs.file.click()">Modifier</v-btn>
                                            <input ref="file" id="avatar-file" type="file" name="name" style="display: none;" v-on:change="saveAvatar" />
                                        </div>
                                    </v-col>

                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                    <v-text-field
                                        v-model="selected_horse.name"
                                        label="Nom"
                                    ></v-text-field>
                                    </v-col>

                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        
                                        <span>Date de naissance : </span>

                                        <v-date-picker is-dark v-model="selected_horse.birth_date" mode="date" label="Date de naissance" is24hr>
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

                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-text-field
                                            v-model="selected_horse.birth_country"
                                            label="Pays de naissance"
                                        ></v-text-field>
                                    </v-col>

                                     <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-text-field
                                            v-model.number="selected_horse.weigth"
                                            label="Poids (kg)"
                                        ></v-text-field>
                                    </v-col>

                                     <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-text-field
                                            v-model.number="selected_horse.size"
                                            label="Taille (cm)"
                                        ></v-text-field>
                                    </v-col>

                                     <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-text-field
                                            v-model="selected_horse.sire_code"
                                            label="Code SIRE"
                                        ></v-text-field>
                                    </v-col>

                                     <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-text-field
                                            v-model="selected_horse.ueln_code"
                                            label="Code UELN"
                                        ></v-text-field>
                                    </v-col>

                                    <v-col
                                            cols="12"
                                            sm="6"
                                        >
                                            <v-select
                                                v-model="selected_horse.sex"
                                                :items="sexs"
                                                item-text="sex"
                                                item-value="value"
                                                label="Sexe"
                                                dense

                                            ></v-select>
                                    </v-col>

                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-select
                                                v-model="selected_horse.user_id"
                                                :items="users"
                                                item-text="name"
                                                item-value="value"
                                                label="Pensionnaire"
                                                dense
                                            ></v-select>
                                    </v-col>

                                </v-row>
                                </v-container>
                            </v-form>
                        </div>

                        <div class="subscriptions-edit section" v-if="selected_section == 'Souscriptions'">
                            <v-form>
                                <v-container>
                                    <v-row>
                                        <v-col
                                            cols="12"
                                            sm="6"
                                        >
                                            <v-select
                                                v-model="selected_horse.pension_id"
                                                :items="pensions"
                                                item-text="name"
                                                item-value="value"
                                                label="Pension"
                                                dense
                                            ></v-select>
                                        </v-col>

                                        <v-col
                                            cols="12"
                                            sm="6"
                                        >
                                            <v-select
                                                v-model="selected_horse.options"
                                                :items="options"
                                                item-text="name"
                                                item-value="value"
                                                attach
                                                chips
                                                label="Options"
                                                dense
                                                multiple
                                            ></v-select>
                                        </v-col>

                                        <v-col>
                                            <SubscriptionComponent :horse="selected_horse" :user="selected_horse.user" />
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-form>
                        </div>
                    </v-container>
                </v-card-text>

                <v-card-actions class="d-flex justify-center">
                    <v-btn v-if="!create" color="red" @click="deleteHorse">Supprimer <v-icon>mdi-close</v-icon></v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script lang="ts">
import {Vue, Component} from 'vue-property-decorator'
import Admin from '../../Types/Admin';
import { HorseInterface } from '../../Types/Horse';
import { UserInterface } from '../../Types/User';
import axios from "axios"
import SubscriptionComponent from '../../Components/SubscriptionComponent.vue'

@Component({
    components: {
        SubscriptionComponent
    }
})
export default class AdminHorses extends Vue {

    private get user(): UserInterface {
        return this.$store.state.user;
    }

    private horse_sections = ["Informations", "Souscriptions"]
    private selected_section = "Informations"

    private get admin_data() {
        return this.$store.state.admin_data;
    }

    private edit = false;

    private loading = false;

    private filter = "";

    private createHorseDialog = false;

    private filtered_horses = []

    private create = false;

    private options = [];
    private pensions = [];
    private users = [];

    private sexs: {sex: string, value: string}[] = [
        {sex: 'Male', value: "male"},
        {sex: 'Femelle', value: "female"}
    ]

    private selected_horse: any = {
                name: "",
                size: 0,
                weigth: 0,
                birth_date: "",
                sire_code: "",
                ueln_code: "",
                birth_country: "",
                storage_path: "",
                sex: "",
                user_id: null,
                pension_id: null,
                options: []
            }

    private allOrFilter() {
        if(this.filter.length > 3) {
            return this.filtered_horses;
        } else return this.admin_data.horses;
    }

    private filterHorses() {
        if(this.filter.length > 3) {
            this.filtered_horses = [];

            for(let horse of this.admin_data.horses) {
                
                const string_user = JSON.stringify(horse).toLowerCase();
                const filter = this.filter.toLowerCase();
                if (string_user.includes(filter)) this.filtered_horses.push(horse)

            }
        }
    }

    private sexIcon(horse: HorseInterface): {icon: string, color: string} {
        if(horse) {
            switch(horse.sex) {
                case "male":
                    return {icon: "mdi-gender-male", color: "blue"}
                default:
                    return {icon: "mdi-gender-female", color: "pink"}
            }
        } 
        return {icon: "mdi-gender-male", color: "blue"}
    }

    private editHorse(horse: any = null) {
        if(horse) {
            this.edit = true;
            this.selected_horse = horse;
            this.selected_horse.pension_id = horse.pension.id

            this.selected_horse.user_id = horse.user.id

            this.selected_horse.options = []

            for (const option of horse.options) {
                this.selected_horse.options.push(option)
            }

            this.create = false;
        } else {
            this.selected_horse = this.default_horse;
            this.create = true;
        }

        this.createHorseDialog = true;
    }

    private horse_user = null;

    private default_horse = {
        name: "",
        size: 0,
        weigth: 0,
        birth_date: "",
        sire_code: "",
        ueln_code: "",
        birth_country: "",
        storage_path: "",
        sex: "",
        user_id: null,
        pension_id: null,
        options: []
    }

    private formatDate(date: any): string {
        date = new Date(date);
        return `${date.getUTCFullYear()}-${date.getUTCMonth()+1}-${date.getUTCDate()} 00:00:00`
    }

    private async save() {
        this.selected_horse.birth_date = this.formatDate(this.selected_horse.birth_date)
        
        if(this.create) {
            let {data} = await axios.post(`http://localhost:8000/api/horses/store`, this.selected_horse, {headers: {
                "Authorization": 'Bearer ' + this.user?.api_token
            }})
            if(data.success) {
                this.$store.dispatch('update', 'horses')
            } else if (data.error) {
                console.log(data)
            } else {
                console.log(data)
            }
        } else {

            await axios.put(`http://localhost:8000/api/horses/${this.selected_horse.id}/update_photo`, {storage_path: this.selected_horse.storage_path}, {
                headers: {
                    'Authorization': 'Bearer ' + this.user.api_token
                }
            })

            let {data} = await axios.put(`http://localhost:8000/api/horses/${this.selected_horse.id}/update`, this.selected_horse, {
                headers: {
                    'Authorization': 'Bearer ' + this.user.api_token
                }
            })
            if(data.success) {
                this.$store.dispatch('update', 'horses')
            } else if (data.error) {
                console.log(data)
            } else {
                console.log(data)
            }
        }

        this.createHorseDialog = false;
    }


    private async saveAvatar(event: any) {
        this.loading = true;
        let reader = new FileReader();

        reader.onloadend = async (evt: any) => {
            if(evt.target.readyState == FileReader.DONE) {
                this.selected_horse.storage_path = reader.result as string
            }
        }

        await reader.readAsDataURL(event.target.files[0])

        this.loading = false;
    }

     private async deleteHorse() {
        let {data} = await axios.delete(`http://localhost:8000/api/horses/${this.selected_horse.id}/destroy`, {
            headers: {
                'Authorization': 'Bearer ' + this.user.api_token
            }
        })
        if(data.success) {
            this.$store.dispatch('update', 'horses')
        } else if (data.error) {
            console.log(data)
        } else {
            console.log(data)
        }

        this.createHorseDialog = false;
    }

    private mounted() {
        for (const pension of this.admin_data.pensions) {
            this.pensions.push(
                {
                    name: pension.name,
                    value: pension.id
                }
            )
        }

        for (const option of this.admin_data.options) {
            this.options.push(
                {
                    name: option.name,
                    value: option.id
                }
            )
        }

        for (const user of this.admin_data.users) {
            this.users.push(
                {
                    name: user.email,
                    value: user.id
                }
            )
        }
        
    }

}
</script>

<style scoped>
    .horse-avatar {
        max-height: 80px;
        max-width: 80px;

        border-radius: 50px;
    }

    .horse-name {
        font-weight: bold;
        font-size: 20px;
    }

    .horse-widget {
        border: solid 2px;
        
        padding: 8px 15px 8px 15px;
        margin: 5px 0 5px 0;

        border-radius: 30px;
    }

    .horses-list {
        padding-bottom: 100px;
    }

    .horse-edit-avatar {
        max-width: 100px;
        max-height: 100px;
        min-height: 100px;

        border-radius: 50px;
    }

    .avatar-edit-container {

        display: flex;
        justify-content: space-around;
        align-items: center;
    }
</style>