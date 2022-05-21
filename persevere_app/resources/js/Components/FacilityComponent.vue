<template>
    <v-card
        :key="facility.id"
        :loading="loading"
        class="facility"
        max-width="374"
    >
        <v-img
            v-for="image in facility.images"
            :key="image"
            height="100"
            :src="image"
        ></v-img>

        <v-card-title>{{facility.name}}</v-card-title>
    </v-card>
</template>

<script lang="ts">
import {Vue, Component, Prop} from "vue-property-decorator"

import Facility, {FacilityInterface} from '../Types/Facility'

export default class FacilityComponent extends Vue {
    @Prop(Facility) readonly facility!: FacilityInterface
    @Prop({default: false}) readonly compact!: boolean
}

</script>