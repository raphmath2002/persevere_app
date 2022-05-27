<template>
    <v-container>
        <div class="current-pensions">
            <div v-if="user">
                <v-row class="d-flex flex-column">
                    <v-col v-for="horse in user.horses" :key="horse.id">
                        <div class="pension" v-if="horse.pension">
                            <ul>
                                <li><span>Pension :</span> {{horse.pension.name}}</li>
                                <li><span>Description :</span> {{horse.pension.description}}</li>
                                <li><span>Prix mensuel :</span> {{horse.pension.price}}€</li>
                                <li><span>Cheval :</span> {{horse.name}}</li>
                            </ul>
                        </div>
                    </v-col>
                </v-row>

                <v-row class="d-flex flex-column">
                    <v-col v-for="horse in user.horses" :key="horse.id">
                        <v-col v-for="option in horse.options" :key="option.id" >
                            <div class="option">
                                <ul>
                                    <li><span>Option :</span> {{option.name}}</li>
                                    <li><span>Description :</span> {{option.description}}</li>
                                    <li><span>{{option.option_type == "mensual" ? 'Prix mensuel :' : 'Prix :'}}</span> {{option.price}}€</li>
                                    <li><span>Cheval :</span> {{horse.name}}</li>
                                </ul>
                            </div>
                        </v-col>
                    </v-col>
                </v-row>
            </div>

            <div v-else>
                <v-row>
                    <v-col class="d-flex justify-center">
                        <div class="pension" v-if="horseObject.pension">
                            <ul>
                                <li><span>Pension :</span> {{horseObject.pension.name}}</li>
                                <li><span>Description :</span> {{horseObject.pension.description}}</li>
                                <li><span>Prix mensuel :</span> {{horse.pension.price}}€</li>
                            </ul>
                        </div>
                    </v-col>
                </v-row>

                <v-row class="d-flex flex-column">
                    <v-col v-for="option in horseObject.options" :key="option.id" >
                        <div class="option">
                            <ul>
                                <li><span>Option :</span> {{option.name}}</li>
                                <li><span>Description :</span> {{option.description}}</li>
                                <li><span>{{option.option_type == "mensual" ? 'Prix mensuel :' : 'Prix :'}}</span> {{option.price}}€</li>
                            </ul>
                        </div>
                    </v-col>
                </v-row>
            </div>
        </div>
    </v-container>
</template>

<script lang="ts">
import {Vue, Component, Prop} from "vue-property-decorator"
import Horse, { HorseInterface } from "../Types/Horse"
import User, {UserInterface,emptyUser} from '../Types/User'

@Component
export default class SubscriptionComponent extends Vue {
    @Prop() readonly user!: UserInterface
    @Prop() readonly horse!: any

    private get horseObject() {
        return this.horse
    }
}
</script>

<style>
    ul {
        list-style: none;
    }

    .current-pensions span {
        font-weight: bold;
    }

    .option {
        border: solid black 1px;

    }

    .pension {
        border-radius: 20px;
        padding: 10px 20px 10px 0;
        background-color: #d6fffd;
    }
</style>