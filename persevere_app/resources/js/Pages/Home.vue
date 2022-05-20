<template>
    <div>
        hello
    </div>
</template>

<script>

import {Vue, Component} from "vue-property-decorator"

@Component
export default class Home extends Vue {
    async mounted() {
        // TODO check user connecté
        if(1!=1) this.$router.push({name: 'login'});
    }

}

</script>