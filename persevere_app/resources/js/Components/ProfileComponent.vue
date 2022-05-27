<template>
    <v-container>
        <div class="profile-component">

        <div class="d-flex justify-space-between">
            <h1>Profil</h1>
            <v-progress-circular
                v-if="loading"
                indeterminate
                color="red"
            ></v-progress-circular>
        </div>
        

        <div class="profil-section-container">
            <v-select
                v-model="selected_section"
                :items="sections"
                outlined
            ></v-select>
        </div>

        <v-container>
            <div class="informations_section" v-if="selected_section == 'Informations'">
                

                <div class="avatar-edit-container">
                    <v-img class="user-avatar" :src="user.storage_path"></v-img>
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

                <div class="bills-container">
                    <h2>Factures</h2>
                   
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
</template>

<script lang="ts">
import {Vue, Component, Prop} from "vue-property-decorator"
import User, {UserInterface} from '../Types/User'
import axios from 'axios'
@Component
export default class ProfileComponent extends Vue {
    @Prop() readonly user!: UserInterface
    @Prop({default: false}) readonly mobile: boolean
    @Prop({default: false}) readonly create: boolean
    
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
    private error_text = ""
    private snackbar = false
    private hasPassword = true;
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
        if(this.selected_section == 'Mot de passe') {
            this.changePassword();
            return
        }
        this.loading = true;
        if(!this.create) {
            let {data} = await axios.put(`http://localhost:8000/api/users/${this.user?.id}/update`, this.new_user, {
                headers: {
                    'Authorization': 'Bearer' + this.user.api_token
                }
            })
            if(data.success) {
                this.$store.commit('SET_USER', data.success as UserInterface);
            } else if (data.error) {
                this.displayError(data.error)
            } else {
                console.log(data)
            }
            
        }
        this.loading = false;
    }
    private async saveAvatar(event: any){
        this.loading = true;
        let reader = new FileReader();
        reader.onloadend = async (evt: any) => {
            if(evt.target.readyState == FileReader.DONE) {
                let {data} = await axios.put(`http://localhost:8000/api/users/${this.user?.id}/update_photo`,
                {
                    "storage_path": reader.result
                }, {headers: {
                    "Authorization": 'Bearer ' + this.user?.api_token
                }})
               
                if(data.success) {
                    this.$store.commit('SET_USER', data.success as UserInterface);
                } else if (data.error) {
                    this.displayError(data.error)
                } else {
                    console.log(data)
                }
            }
        }
        await reader.readAsDataURL(event.target.files[0])
        this.loading = false;
    }
    private async changePassword(): Promise<void> {
        this.loading = true;
        let {data} = await axios.put(`http://localhost:8000/api/users/${this.user?.id}/update_password`, this.passwords, {headers: {
            "Authorization": 'Bearer ' + this.user?.api_token
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
    ul {
        list-style: none;
    }
    .current-pensions span {
        font-weight: bold;
    }
    .option, .pension {
        border: solid black 1px;
    }
</style>