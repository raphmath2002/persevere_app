<template>
    <v-container>
        <h1>Notifications</h1>

        <v-row>
            <v-col v-for="info in infos" :key="info.id">
                <NotificationComponent :info="info" />
            </v-col>
        </v-row>
    </v-container>
</template>

<script lang="ts">
import {Vue, Component} from "vue-property-decorator"
import Information, {InformationInterface} from "../Types/Information"
import NotificationComponent from '../Components/NotificationComponent.vue'

@Component({
    components: {
        NotificationComponent
    }
})
export default class Notifications extends Vue {

    private infos: InformationInterface[] = [
        {id: 1, title: "Rénovation du garage", markdown: "# Yo\n* Salut\n * coucou\n[test](https://google.fr)"}
    ]

    /*
    private get infos(): InformationInterface {
        return this.$store.state.informations;
    }*/
}

</script>
