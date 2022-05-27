<template>
    <v-container>
        <h1>Notifications</h1>

        <v-row>
            <v-col cols="12" v-for="info in infos" :key="info.id">
                <NotificationComponent :info="info" />
            </v-col>
        </v-row>
    </v-container>
</template>

<script lang="ts">
import {Vue, Component} from "vue-property-decorator"
import Information, {InformationInterface} from "../Types/Information"
import NotificationComponent from '../Components/NotificationComponent.vue'
import axios from 'axios'
import { UserInterface } from "../Types/User"

@Component({
    components: {
        NotificationComponent
    }
})
export default class Notifications extends Vue {

    private get infos(): InformationInterface[] {
        return this.$store.state.notifs;
    }

    private get user(): UserInterface{
        return this.$store.state.user;
    }
}

</script>
