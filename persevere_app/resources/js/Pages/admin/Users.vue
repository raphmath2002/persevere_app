<template>
    <v-container>
        <v-row>
            <v-col>
                <div class="d-flex justify-space-between">
                    <h1>Utilisateurs</h1>
                    <v-icon @click="createUser" size="50px" color="green">mdi-plus</v-icon>
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
                <div class="user-widget d-flex" @click="editUser(user)">
                    <v-img width="90px" height="90px" class="user-widget-image" :src="user.storage_path"></v-img>
                    <div class="user-widget-infos d-flex flex-column justify-center align-center">
                        <span class="user-widget-name">{{user.name}}  {{user.firstname}}</span>
                        <span class="user-widget-email">{{user.email}}</span>
                    </div>
                </div>
            </v-col>
        </v-row>

        <v-dialog
            :fullscreen="$vuetify.breakpoint.xsOnly"
            v-model="createUserDialog"
        >
            <ProfileComponent :create="true" :user="default_user" @done="closeDialogs" />
            
        </v-dialog>

        <v-dialog
            :fullscreen="$vuetify.breakpoint.xsOnly"
            v-model="editUserDialog"
        >
            <ProfileComponent :admin="true" :user="selected_user" @done="closeDialogs" />
            
        </v-dialog>
    </v-container>
</template>

<script lang="ts">
import {Vue, Component} from "vue-property-decorator"
import {UserInterface} from '../../Types/User'
import Admin from '../../Types/Admin'
import ProfileComponent from '../../Components/ProfileComponent.vue'

@Component({
    components: {
        ProfileComponent
    }
})
export default class Users extends Vue {
    private get admin_data(): Admin{
        return this.$store.state.admin_data
    }

    private editUserDialog = false;
    private createUserDialog = false;
    
    private filter = "";


    private createUser() {
        this.createUserDialog = true;
    }

    private editUser(user: UserInterface) {
        this.selected_user = user;
        this.editUserDialog = true;
        
    }

    private closeDialogs() {
        this.createUserDialog = false;
        this.editUserDialog = false;
    }

    private default_user: UserInterface = {
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

    private selected_user: UserInterface = null;

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