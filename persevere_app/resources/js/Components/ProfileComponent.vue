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
                <h2>Souscriptions</h2>
                <div class="current-pensions">
                    <v-row class="d-flex flex-column">
                        <v-col v-for="pension in new_user.pensions" :key="pension.id" >
                            <div class="pension">
                                <ul>
                                    <li><span>Pension :</span> {{pension.name}}</li>
                                    <li><span>Description :</span> {{pension.description}}</li>
                                    <li><span>Prix mensuel :</span> {{pension.price}}€</li>
                                    <li><span>Cheval :</span> {{pension.horse.name}}</li>
                                </ul>
                            </div>
                        </v-col>

                    </v-row>

                    <v-row class="d-flex flex-column">
                        <v-col v-for="option in new_user.options" :key="option.id" >
                            <div class="option">
                                <ul>
                                    <li><span>Option :</span> {{option.name}}</li>
                                    <li><span>Description :</span> {{option.description}}</li>
                                    <li><span>Prix mensuel :</span> {{option.price}}€</li>
                                    <li><span>Cheval :</span> {{option.horse.name}}</li>
                                </ul>
                            </div>
                        </v-col>

                    </v-row>
                    
                </div>

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
                            @input="_=>loginInfo.password=_"
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
        
        <v-btn @click="save">Sauvegarder</v-btn>

        </div>
    </v-container>
</template>

<script lang="ts">

import {Vue, Component, Prop} from "vue-property-decorator"
import User, {UserInterface} from '../Types/User'
import axios from 'axios'

@Component
export default class ProfileComponent extends Vue {
    @Prop({default: User.emptyUser()}) readonly user!: UserInterface
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
        this.loading = true;
        if(!this.create) {
            let {data} = await axios.put(`http://localhost:8000/api/users/${this.user?.id}/update`, this.new_user, {
                headers: {
                    'Authorization': 'Bearer' + this.user.api_token
                }
            })
            this.$store.commit('SET_USER', data.res.data as UserInterface);
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
               
    
                this.$store.commit('SET_USER', data.res.data as UserInterface)
            }
        }

        await reader.readAsDataURL(event.target.files[0])

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