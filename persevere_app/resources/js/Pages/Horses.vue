<template>
    <v-container>
        <div class="horse-page">
            <div class="page-top">
                <h1>Mes chevaux</h1>
            </div>
            
            
            <div class="page-content">
                <v-row>
                    <HorseComponent
                        v-for="horse in horses"
                        :key="horse.id"
                        :horse="horse"
                    />
                </v-row>
            </div>
        </div>
    </v-container>
</template>

<script lang="ts">

import {Vue, Component} from "vue-property-decorator"
import Horse, {HorseInterface} from '../Types/Horse'
import HorseComponent from '../Components/HorseComponent.vue'

@Component({
    components: {
        HorseComponent
    }
})
export default class Horses extends Vue {
    private get horses(): HorseInterface {
        return this.$store.state.user.horses;
    }
}

</script>

<style scoped>

    .page-content{
        width: 100%;
        height: 80%;
        padding: 5px 10px 5px 10px;
    }

    
</style>