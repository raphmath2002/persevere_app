<template>
    <v-container>
        <h1>Dashboard</h1>

        <v-row>
            <v-col>
                <v-card dark>
                    <v-card-title>
                        <h2>Statistiques</h2>
                    </v-card-title>

                    <v-card-text>
                        <ul class="stats-list">
                            <li>Pensionnaires : {{getUsersByLevel('customer').length}}</li>
                            <li>Chevaux : {{admin_data.horses.length}}</li>
                            <li>Administrateurs : {{getUsersByLevel('admin').length}}</li>
                            <li>Professionnels : {{admin_data.professionals.length}}</li>
                            <li>Tickets en cours : {{admin_data.tickets.length}}</li>
                        </ul>
                    </v-card-text>

                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script lang="ts">
import {Vue, Component} from "vue-property-decorator"
import {UserInterface} from '../../Types/User'

@Component
export default class Dashboard extends Vue {
    private get admin_data() {
        return this.$store.state.admin_data
    }

    private getUsersByLevel(level: string): UserInterface[] {
        const users: UserInterface[] = []

        for(let user of this.admin_data.users) {
            if(user.auth_level == level) users.push(user);
        }

        return users;
    }
}
</script>

<style lang="">
    
</style>