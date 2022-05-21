<template>
    <ProfileComponent :user="user" />
</template>

<script lang="ts">

import {Vue, Component} from "vue-property-decorator"
import ProfileComponent from '../Components/ProfileComponent.vue'
import { HorseInterface } from "../Types/Horse"
import { UserInterface } from "../Types/User"

@Component({
    components: {
        ProfileComponent
    }
})
export default class Profile extends Vue {

    private get user(): UserInterface {
        return this.$store.state.user;
    }

}

</script>