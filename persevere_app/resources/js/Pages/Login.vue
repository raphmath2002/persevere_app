<template>
    <v-container>
        <div v-if="step== 'login'" class="login-container d-flex flex-column">
            <div class="head-container d-flex flex-column align-center">
                <h1>Bienvenue</h1>
                <span>Veuillez vous connecter</span>
            </div>

            <div class="form-container">
                <v-form v-model="login_valid">
                    <v-container>
                    <v-row>
                        <v-col
                        cols="12"
                        md="4"
                        >
                        <v-text-field
                            v-model="loginInfo.email"
                            :rules="rules.emailRules"
                            label="E-mail"
                            required
                        ></v-text-field>
                        </v-col>

                        <v-col
                        cols="12"
                        md="4"
                        >
                        <v-text-field
                            autocomplete="current-password"
                            v-model="loginInfo.password"
                            label="Mot de passe"
                            :append-icon="hasPassword ? 'mdi-eye' : 'mdi-eye-off'"
                            @click:append="() => (hasPassword = !hasPassword)"
                            :type="hasPassword ? 'password' : 'text'"
                            :rules="rules.passwordRules"
                            @input="_=>loginInfo.password=_"
                        ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col class="d-flex justify-space-between">
                            <a @click="goToVerif">Première connexion ?</a>
                            <v-btn 
                                @click="login"
                                color="green"
                            >
                                Connexion
                            </v-btn>
                        </v-col>
                    </v-row>

                    </v-container>
                </v-form>
            </div>
        </div>

        <div v-else-if="step == 'verification'">
            <v-icon 
                size="40px"
                @click="step = 'login'"
            >mdi-arrow-left-circle</v-icon>

            <div class="head-container d-flex flex-column align-center">
                <h1>Es-ce bien vous ?</h1>
                <span>Entrez le code envoyé sur {{loginInfo.email}}</span>
            </div>

            <div class="form-container">
                <v-form v-model="valid">
                    <v-container>
                    <v-row>
                        <v-col
                        cols="12"
                        md="4"
                        >
                        <v-text-field
                            v-model="verification_code"
                            :rules="rules.verificationRules"
                            label="Code de verification"
                            placeholder="XXXXX"
                            required
                        ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col class="d-flex justify-center">
                            <v-btn
                                color="primary"
                                @click="step = 'password'"
                            >
                                Confirmer
                            </v-btn>
                        </v-col>
                    </v-row>
                    </v-container>
                </v-form>
            </div>
        </div>

        <div v-else class="password-container">

             <v-icon 
                size="40px"
                @click="step = 'login'"
            >mdi-arrow-left-circle</v-icon>
            <div class="head-container d-flex flex-column align-center">
                <h1>Bienvenue Louis Deguitre</h1>
                <span>Veuillez changer votre mot de passe</span>
            </div>

            <div class="form-container">
                <v-form v-model="password_valid">
                    <v-container>
                    <v-row>
                       <v-col
                        cols="12"
                        md="4"
                        >
                        <v-text-field
                            autocomplete="current-password"
                            v-model="passwords.password"
                            label="Mot de passe"
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
                            v-model="passwords.confirmation"
                            label="Confirmation"
                            :rules="rules.passwordVerifRules"
                            type="password"
                        ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col class="d-flex justify-center">
                            
                            <v-btn 
                                @click="changePassword"
                                color="primary"
                            >
                                Modifier
                            </v-btn>
                        </v-col>
                    </v-row>

                    </v-container>
                </v-form>
            </div>
        </div>

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
    </v-container>
</template>

<script lang="ts">

import {Vue, Component} from "vue-property-decorator"
import axios from "axios";

@Component
export default class Login extends Vue {

    private step = "login"

    private snackbar = false
    private error_text = ""

    private loginInfo: {email: string, password: string} = {
        email: "",
        password: ""
    }

    private passwords: {password: string, confirmation: string} = {
        password: "",
        confirmation: ""
    }

    private verification_code = ""

    private login_valid = false;
    private verif_valid = false;
    private password_valid = false;

    private hasPassword = true;

    private validate_code(code: string): boolean{
        return true
    }

    private rules = {
        emailRules: [
            (v: string) => !!v || 'E-mail requis',
            (v: string) => /.+@.+/.test(v) || 'L\'E-mail doit etre valide',
        ],

        passwordRules: [
            (v: string) => /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/.test(v) ||
            "Min. 8 characters with at least one capital letter, a number and a special character."
        ],

        verificationRules: [
            (v: string) => !!v || 'Code de verification requis',
            (v: string) => v.length > 5 || 'Code mal formé',
            (v: string) => this.validate_code(v) || 'Code invalide'
        ],

        passwordVerifRules: [
            (v: string) => !!v || 'Mot de passe requis',
            (v: string) => v == this.passwords.password || 'Les mots de passes doivent correspondre',
        ]
    }

    private displayError(message: string): void {
        this.error_text = message;
        this.snackbar = true;
    }

    private async login(): Promise<void> {
        // TODO check identifiants user

        this.$store.commit('SHOW_INTERFACE', true);
        this.$store.commit('LOGGED', true);
        this.$router.push({name: 'home'})
    }

    private async goToVerif(): Promise<void> {

        if(!/.+@.+/.test(this.loginInfo.email)) this.displayError("Merci de renseigner un email valide")
        else {
            // TODO check user inscrit
            //this.displayError("Vous n'etes pas inscrit !")
            this.step = 'verification'
        }
        
    }

    private async changePassword(): Promise<void> {

    }

    mounted() {
        if(this.$store.state.logged) this.$router.push({name: 'home'})
    }
}


</script>