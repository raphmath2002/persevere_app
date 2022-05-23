<template>
    <v-card>
        <v-container>
        <div class="profile-component">

        <div class="d-flex justify-space-between">
            <h1>Profil</h1>
            <div>
                <v-progress-circular
                    v-if="loading"
                    indeterminate
                    color="red"
                ></v-progress-circular>
                <v-icon v-if="create || admin" color="red" size="50px" @click="$emit('done')">mdi-close</v-icon>
            </div>
            
        </div>
        

        <div class="profil-section-container">
            <v-select
                v-if="!create && !admin"
                v-model="selected_section"
                :items="sections"
                outlined
                dense
            ></v-select>

            <v-select
                v-else
                v-model="new_user.auth_level"
                :items="roles"
                item-text="name"
                item-value="value"
                dense
                label="Role"
                outlined
            ></v-select>
        </div>

        <v-container>
            <div class="informations_section" v-if="selected_section == 'Informations'">
                

                <div class="avatar-edit-container">
                    <v-img class="user-avatar" :src="new_user.storage_path"></v-img>
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
                                        v-model="new_user.email"
                                        label="Adresse email"
                                    ></v-text-field>
                                </v-col>

                                <v-col
                                    cols="12"
                                    md="4"
                                >
                                    <v-text-field
                                        v-model="new_user.firstname"
                                        label="Prénom"
                                    ></v-text-field>
                                </v-col>

                                <v-col
                                    cols="12"
                                    md="4"
                                >
                                    <v-text-field
                                        v-model="new_user.name"
                                        label="Nom"
                                    ></v-text-field>
                                </v-col>

                                <v-col
                                    cols="12"
                                    md="4"
                                >
                                    <v-text-field
                                        v-model="new_user.phone"
                                        label="Téléphone"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-form>

                    <div>
                        <span>Date de naissance : </span>

                        <v-date-picker is-dark v-model="new_user.birth_date" mode="date" label="Date de naissance" is24hr>
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

            

            <div class="address-edit-container section" v-if="selected_section == 'Informations'">
                <h2>Adresse postale</h2>

                <v-form>
                    <v-container>
                        <v-row>
                            <v-col
                                cols="12"
                                md="4"
                            >
                                <v-text-field
                                    v-model="new_user.postal_address"
                                    label="Adresse (numéro + voie)"
                                ></v-text-field>
                            </v-col>

                            <v-col
                                cols="12"
                                md="4"
                            >
                                <v-text-field
                                    v-model="new_user.postal_code"
                                    label="Code postal"
                                ></v-text-field>
                            </v-col>

                            <v-col
                                cols="12"
                                md="4"
                            >
                                <v-text-field
                                    v-model="new_user.city"
                                    label="Ville"
                                ></v-text-field>
                            </v-col>

                            <v-col
                                cols="12"
                                md="4"
                            >
                                <v-text-field
                                    v-model="new_user.country"
                                    label="Pays"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-form>
            </div>

            <div class="subscriptions-container section" v-if="selected_section == 'Souscription'">
                <h2>Souscriptions</h2>
                
                <SubscriptionComponent :user="user" />

                <div class="bills-container">
                    <h2>Factures</h2>
                   <!-- TODO bills -->
                </div>
            </div>

            <div class="password-edit-container section" v-if="selected_section == 'Mot de passe'">
                <v-form>
                    <v-container>
                    <v-row>

                        <v-col
                            cols="12"
                            md="4"
                        >
                        <v-text-field
                            v-model="passwords.old_password"
                            label="Mot de passe actuel"
                            type="password"
                        ></v-text-field>
                        </v-col>

                       <v-col
                        cols="12"
                        md="4"
                        >
                        <v-text-field
                            autocomplete="current-password"
                            v-model="passwords.new_password"
                            label="Nouveau mot de passe"
                            :append-icon="hasPassword ? 'mdi-eye' : 'mdi-eye-off'"
                            @click:append="() => (hasPassword = !hasPassword)"
                            :type="hasPassword ? 'password' : 'text'"
                            :rules="rules.passwordRules"
                            @input="_=>passwords.new_password=_"
                        ></v-text-field>
                        </v-col>

                        <v-col
                        cols="12"
                        md="4"
                        >
                        <v-text-field
                            autocomplete="current-password"
                            v-model="passwords.confirm_password"
                            label="Confirmation"
                            :rules="rules.passwordVerifRules"
                            type="password"
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
        
        <v-btn @click="save" v-if="selected_section != 'Souscription'">Sauvegarder</v-btn>

        </div>
        </v-container>
    </v-card>
</template>

<script lang="ts">

import {Vue, Component, Prop} from "vue-property-decorator"
import User, {UserInterface, emptyUser} from '../Types/User'
import axios from 'axios'
import SubscriptionComponent from "../Components/SubscriptionComponent.vue"

@Component({
    components: {
        SubscriptionComponent
    }
})
export default class ProfileComponent extends Vue {
    @Prop() readonly user!: UserInterface
    @Prop({default: false}) readonly mobile: boolean
    @Prop({default: false}) readonly create: boolean
    @Prop({default: false}) readonly admin: boolean

    private get loggedUser(): UserInterface {
        return this.$store.state.user;
    }

    private new_user = JSON.parse(JSON.stringify(this.user));
    private loading = false;

    private sections: string[] = ["Informations", "Souscription", "Mot de passe"]
    private selected_section = "Informations"

    private passwords: {old_password: string, new_password: string, confirm_password: string} = {
        old_password: "",
        new_password: "",
        confirm_password: ""
    }

    private displayError(message: string): void {
        this.error_text = message;
        this.snackbar = true;
    }

    private roles: {name: string, value: string}[] = [
        {name: 'Super administrateur', value: 'master'},
        {name: 'Administrateur', value: 'admin'},
        {name: 'Pensionnaire', value: 'customer'}
    ]

    private formatDate(date: Date): string {
        return `${date.getFullYear()}-${date.getMonth()}-${date.getDate()} 00:00:00`;
    }

    private error_text = ""
    private snackbar = false

    private hasPassword = true;

    private avatarBase64 = "";

    private rules = {
        emailRules: [
            (v: string) => !!v || 'E-mail requis',
            (v: string) => /.+@.+/.test(v) || 'L\'E-mail doit etre valide',
        ],

        passwordRules: [
            (v: string) => /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/.test(v) ||
            "Min. 8 characters with at least one capital letter, a number and a special character."
        ],

        passwordVerifRules: [
            (v: string) => !!v || 'Mot de passe requis',
            (v: string) => v == this.passwords.new_password || 'Les mots de passes doivent correspondre',
        ]
    }

    private async save() {

        this.new_user.birth_date =  this.formatDate(this.new_user.birth_date);

        if(this.selected_section == 'Mot de passe') {
            this.changePassword();
            return
        }

        this.loading = true;
        if(!this.create) {
            let {data} = await axios.put(`http://localhost:8000/api/users/${this.user?.id}/update`, this.new_user, {
                headers: {
                    'Authorization': 'Bearer ' + this.loggedUser.api_token
                }
            })

            if(data.success) {
                this.$store.commit('SET_USER', data.success as UserInterface);
            } else if (data.error) {
                this.displayError(data.error)
            } else {
                console.log(data)
            }
            
        } else {
            
            let {data} = await axios.post(`http://localhost:8000/api/users/store`, this.new_user, {
                headers: {
                    'Authorization': 'Bearer ' + this.loggedUser.api_token
                }
            })

            if(data.success) {
                this.$emit("done")
            } else if (data.error) {
                this.displayError(data.error)
            } else {
                console.log(data)
            }
        }

        this.loading = false;
    }

    private async saveAvatar(event: any) {
        this.loading = true;
        let reader = new FileReader();

        reader.onloadend = async (evt: any) => {
            if(evt.target.readyState == FileReader.DONE) {
                if(!this.create) {
                    let {data} = await axios.put(`http://localhost:8000/api/users/${this.user.id}/update_photo`,
                    {
                        "storage_path": reader.result
                    }, {headers: {
                        "Authorization": 'Bearer ' + this.loggedUser.api_token
                    }})
                        
                    if(data.success) {
                        this.$store.commit('SET_USER', data.success as UserInterface);
                    } else if (data.error) {
                        this.displayError(data.error)
                    } else {
                        console.log(data)
                    }
                } else {

                    this.new_user.storage_path = reader.result as string
                }
               
            }
        }

        await reader.readAsDataURL(event.target.files[0])

        this.loading = false;
    }

    private async changePassword(): Promise<void> {
        this.loading = true;
        let {data} = await axios.put(`http://localhost:8000/api/users/${this.user?.id}/update_password`, this.passwords, {headers: {
            "Authorization": 'Bearer ' + this.loggedUser.api_token
        }})

        if(data.success) {
            this.displayError(data.success)
        } else if (data.error) {
            this.displayError(data.error)
        } else {
            console.log(data)
        }
        this.loading = false;
    }
    
}

</script>

<style scoped>
    .user-avatar {
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

    .section {
        margin: 20px 0 20px 0;
    }

    .profile-component {
        padding-bottom: 100px;
    }
</style>