<template>
    <v-container>
        <v-row>
            <v-col>
                <div class="d-flex justify-space-between">
                    <h1>Utilisateurs</h1>
                    <v-icon @click="createUser()" size="50px" color="green">mdi-plus</v-icon>
                </div>
            </v-col>
        </v-row>
        

        <v-row>
            <v-col>
                <v-text-field
                    v-model="filter"
                    label="Filtre"
                    v-on:keyup="filterUsers"
                >
                </v-text-field>
            </v-col>
        </v-row>

        <v-row class="users-list">
            <v-col v-for="user in allOrFilter()" :key="user.id">
                <div class="user-widget d-flex" @click="createUser(user)">
                    <v-img width="90px" height="90px" class="user-widget-image" :src="user.storage_path"></v-img>
                    <div class="user-widget-infos d-flex flex-column justify-center align-center">
                        <span class="user-widget-name">{{user.name}}  {{user.firstname}}</span>
                        <span class="user-widget-email">{{user.email}}</span>
                    </div>
                </div>
            </v-col>
        </v-row>

        <v-dialog
            v-model="createUserDialog"
            :fullscreen="$vuetify.breakpoint.xsOnly"
        >
            <v-card>
                <v-container>
                <div class="profile-component">

                <div class="d-flex justify-space-between">
                    <h1>Edition profil</h1>
                    <div>
                        <v-progress-circular
                            v-if="loading"
                            indeterminate
                            color="red"
                        ></v-progress-circular>
                        <v-icon color="red" size="50px" @click="createUserDialog = false">mdi-close</v-icon>
                    </div>
                </div>
                

                <div class="profil-section-container">
                    <v-select
                        v-model="selected_user.auth_level"
                        :items="user.auth_level == 'master' ? super_roles : admin_roles"
                        item-text="name"
                        item-value="value"
                        dense
                        label="Role"
                        outlined
                    ></v-select>
                </div>

                <v-container>
                    <div class="informations_section">
                        <div class="avatar-edit-container">
                            <v-img class="user-avatar" :src="selected_user.storage_path"></v-img>
                            <v-btn @click="$refs.file.click()">Modifier</v-btn>
                            <input ref="file" id="avatar-file" type="file" name="name" style="display: none;" v-on:change="saveAvatar" />
                        </div>

                        <div class="informations-edit-container section">
                            <h2>Informations</h2>
                            <v-form>
                                <v-container>
                                    <v-row>
                                        <v-col
                                            cols="12"
                                            md="4"
                                        >
                                            <v-text-field
                                                v-model="selected_user.email"
                                                label="Adresse email"
                                            ></v-text-field>
                                        </v-col>

                                        <v-col
                                            cols="12"
                                            md="4"
                                        >
                                            <v-text-field
                                                v-model="selected_user.firstname"
                                                label="Prénom"
                                            ></v-text-field>
                                        </v-col>

                                        <v-col
                                            cols="12"
                                            md="4"
                                        >
                                            <v-text-field
                                                v-model="selected_user.name"
                                                label="Nom"
                                            ></v-text-field>
                                        </v-col>

                                        <v-col
                                            cols="12"
                                            md="4"
                                        >
                                            <v-text-field
                                                v-model="selected_user.phone"
                                                label="Téléphone"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-form>

                            <div>
                                <span>Date de naissance : </span>

                                <v-date-picker is-dark v-model="selected_user.birth_date" mode="date" label="Date de naissance" is24hr>
                                    <template v-slot="{ inputValue, inputEvents }">
                                        <input
                                            class="px-2 py-1 border rounded focus:outline-none border:blue focus:border-blue-300 color:red"
                                            :value="inputValue"
                                            v-on="inputEvents"
                                            style="background-color:#bcbcbc"
                                        />
                                    </template>
                                </v-date-picker>
                            </div>
                        </div>
                    </div>

                    

                    <div class="address-edit-container section">
                        <h2>Adresse postale</h2>

                        <v-form>
                            <v-container>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-text-field
                                            v-model="selected_user.postal_address"
                                            label="Adresse (numéro + voie)"
                                        ></v-text-field>
                                    </v-col>

                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-text-field
                                            v-model="selected_user.postal_code"
                                            label="Code postal"
                                        ></v-text-field>
                                    </v-col>

                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-text-field
                                            v-model="selected_user.city"
                                            label="Ville"
                                        ></v-text-field>
                                    </v-col>

                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-text-field
                                            v-model="selected_user.country"
                                            label="Pays"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-form>
                    </div>
                </v-container>

                <v-snackbar
                    v-model="snackbar"
                    :timeout="3000"
                    color="red"
                >
                    {{ error_text }}

                    <template v-slot:action="{ attrs }">
                        <v-btn
                            color="black"
                            text
                            v-bind="attrs"
                            @click="snackbar = false"
                        >
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </template>
                </v-snackbar>

                    <v-card-actions>
                        <v-btn color="primary" @click="save">Sauvegarder</v-btn>
                        <v-btn v-if="!create" :disabled="user.id == selected_user.id ? true : false" color="red" @click="deleteUser">Supprimer</v-btn>

                    </v-card-actions>

                </div>
                </v-container>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script lang="ts">
import {Vue, Component} from "vue-property-decorator"
import {UserInterface} from '../../Types/User'
import Admin from '../../Types/Admin'
import ProfileComponent from '../../Components/ProfileComponent.vue'
import axios from 'axios'

@Component({
    components: {
        ProfileComponent
    }
})
export default class Users extends Vue {
    private loading = false;
    private snackbar = false;
    private error_text = "";


    private get admin_data(): Admin{
        return this.$store.state.admin_data
    }

    private get user(): UserInterface {
        return this.$store.state.user
    }

    private createUserDialog = false;
    private create = false;
    
    private filter = "";

    private super_roles = [
        {name: "Super Administrateur", value: "master"},
        {name: "Administrateur", value: "admin"},
        {name: "Pensionnaire", value: "customer"}
    ]

    private admin_roles = [
        {name: "Pensionnaire", value: "customer"}
    ]

    private formatDate(date: Date): string {
        return `${date.getFullYear()}-${date.getMonth()+1}-${date.getDate()}`
    }

    private async deleteUser() {
        let {data} = await axios.delete(`http://localhost:8000/api/users/${this.selected_user.id}/destroy`, {
            headers: {
                'Authorization': 'Bearer ' + this.user.api_token
            }
        })
        if(data.success) {
            this.$store.dispatch('update', 'users')
        } else if (data.error) {
            console.log(data)
        } else {
            console.log(data)
        }

        this.createUserDialog = false;
    }


    private createUser(user: UserInterface = null) {
        if(user) {
            this.selected_user = user;
            this.create = false;
        } else {
            this.selected_user = this.default_user;
            this.create = true;
        }

        this.createUserDialog = true;
    }

    private default_user: any = {
        name: "",
        firstname: "",
        email: "",
        phone: "",
        postal_code: "",
        postal_address: "",
        city: "",
        country: "",
        birth_date: "",
        storage_path: "",
        auth_level: ""
    }

    private selected_user: UserInterface = this.default_user;

    private filtered_users = []

    private allOrFilter() {
        if(this.filter.length > 3) {
            return this.filtered_users;
        } else return this.admin_data.users;
    }

    private filterUsers() {

        console.log("OKAY")
        if(this.filter.length > 3) {
            this.filtered_users = [];

            for(let user of this.admin_data.users) {
                
                const string_user = JSON.stringify(user).toLowerCase();
                const filter = this.filter.toLowerCase();
                if (string_user.includes(filter)) this.filtered_users.push(user)

            }
        }
    }

    private async save() {
        if(typeof this.selected_user.birth_date != 'string') {
            this.selected_user.birth_date = this.formatDate(this.selected_user.birth_date)
        }

        if(this.create) {
            

            let {data} = await axios.post(`http://localhost:8000/api/users/store`, this.selected_user, {headers: {
                "Authorization": 'Bearer ' + this.user?.api_token
            }})
            if(data.success) {
                this.$store.dispatch('update', 'users')
            } else if (data.error) {
                console.log(data)
            } else {
                console.log(data)
            }
        } else {
                
             let {data} = await axios.put(`http://localhost:8000/api/users/${this.selected_user.id}/update`, this.selected_user, {
                headers: {
                    'Authorization': 'Bearer ' + this.user?.api_token
                }
            })
            if(data.success) {
                console.log()
                this.$store.dispatch('update', 'users')
            } else if (data.error) {
                console.log(data)
            } else {
                console.log(data)
            }
        }

        this.createUserDialog = false;
    }

    private async saveAvatar(event: any) {
        this.loading = true;
        let reader = new FileReader();

        reader.onloadend = async (evt: any) => {
            if(evt.target.readyState == FileReader.DONE) {
                this.selected_user.storage_path = reader.result as string
            }
        }

        await reader.readAsDataURL(event.target.files[0])

        this.loading = false;
    }
}
</script>

<style>
    .user-widget-image {
        border-radius: 50px;
    }

    .users-list {
        overflow-y: auto;
        padding-bottom: 100px;
    }

    .user-widget {
        border: solid black 1px;
        padding: 10px 15px 10px 15px;
    }

    .user-widget-infos {
        width: 100%;
    }

    .user-widget-name {
        font-weight: bold;
        font-size: 18px;
    }

    .user-widget-email{
        color: gray;
        font-style: italic;
    }
</style>