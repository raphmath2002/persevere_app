<template>
    <v-card>
        <v-card-title class="d-flex justify-space-between">
                <h3>Ajouter/Editer</h3>
                <div>
                    <v-progress-circular
                        v-if="loading"
                        indeterminate
                        color="red"
                    ></v-progress-circular>
                    <v-icon v-else color="green" size="50px" @click="save">mdi-content-save</v-icon>
                    <v-icon color="red" size="50px" @click="$emit('done')">mdi-close</v-icon>
                </div>
        </v-card-title>

        <v-card-text>

            <v-row>
                <v-col cols="12">
                    <div class="image-add-container">
                        <div class="d-flex justify-space-between align-center">
                            <span class="image-title">Images</span>
                            <input ref="file" id="image-file" type="file" name="name" style="display: none;" v-on:change="insertImage" />
                            <v-icon color="green" size="50px" @click="$refs.file.click()">mdi-plus</v-icon>
                        </div>

                        <div class="image-container">
                            <v-img @click="deleteImage(image)" class="image" max-width="200px" v-for="image in images_list" :key="image.id" :src="image.image"></v-img>
                        </div>
                    </div>
                </v-col>
            </v-row>

            <v-form>
                <v-container>
                    <v-row>
                        <v-col
                            cols="12"
                            md="4"
                        >
                            <v-text-field
                                v-model="facility_infos.name"
                                dense
                                label="Nom de l'installation"
                            ></v-text-field>
                        </v-col>

                        <v-col
                            cols="12"
                            md="4"
                        >
                            <v-textarea
                                v-model="facility_infos.description"
                                outlined
                                filled
                                dense
                                label="Description"
                            ></v-textarea>
                        </v-col>

                        <v-col
                            cols="12"
                            md="4"
                        >
                            <v-text-field
                                v-model.number="facility_infos.max_customers"
                                dense
                                label="Nombre max de pensionnaires"
                            ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col cols="12">
                            <div class="d-flex justify-space-between align-center">
                                <span class="image-title">Disponnibilités</span>
                                <v-icon color="green" size="50px" @click="addDayFacility">mdi-plus</v-icon>
                            </div>

                            
                            <v-col>
                                <v-select
                                    v-model="selected_day"
                                    :items="days"
                                    item-text="name"
                                    dense
                                    outlined
                                    filled
                                    return-object
                                >
                                </v-select>
                            </v-col>

                            <v-col cols="12" class="d-flex justify-space-between">
                                <v-col cols="4">
                                    <v-text-field
                                        v-model="day_facility_infos.start"
                                        dense
                                        label="De"
                                        v-on:keyup="checkFrom"
                                    ></v-text-field>
                                </v-col>

                                 <v-col cols="4">
                                    <v-text-field
                                        v-model="day_facility_infos.end"
                                        dense
                                        label="à"
                                        v-on:keyup="checkTo"
                                    ></v-text-field>
                                </v-col>
                            </v-col>

                            <v-col v-for="day_facility in day_facility_list" :key="day_facility.id">
                                <v-card
                                    dark
                                >
                                    <v-card-title>
                                        {{day_facility.day}}
                                    </v-card-title>
                                    <v-container>
                                        <v-card-text class="d-flex flex-column">
                                            <div v-for="dispo in day_facility.dispos" :key="JSON.stringify(dispo)">
                                                <span>De {{dispo.start_hour}}h{{dispo.start_minute}} à {{dispo.end_hour}}h{{dispo.end_minute}}</span>
                                                <v-icon color="red" @click="deleteDayFacilityDispo(day_facility, dispo)">mdi-close</v-icon>
                                            </div>
                                        </v-card-text>
                                    </v-container>
                                    
                                </v-card>
                            </v-col>
                        </v-col>

                    </v-row>
                </v-container>
            </v-form>
        </v-card-text>
        <v-card-actions   class="d-flex justify-center">
            <v-btn
              
                v-if="!news"
                dense
                color="red"
                @click="deleteFacility"
            >
                Supprimer
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script lang="ts">
import {Vue, Component, Prop, Watch} from "vue-property-decorator"
import axios from "axios"
import { UserInterface } from "../../Types/User"
import { FacilityInterface } from "../../Types/Facility"

/**
 * Creation
 * Image
 * Days (heure debut/fin * 2) 
 * 
 * 
 * {
 *  id: 1,
 *  day: 'Lundi',
 *  dispos: [
 *      {start_h: 0, end_h: 0, start_m: 0, end_m: 0}, 
 *      {start_h: 0, end_h: 0, start_m: 0, end_m: 0} 
 *  ]
 *  
 * }
 */

@Component
export default class FacilityEditComponent extends Vue {
    @Prop() readonly facility!: FacilityInterface
    @Prop({default: false}) readonly news: boolean

    private get user(): UserInterface {
        return this.$store.state.user;
    }

    private get admin_data() {
        return this.$store.state.admin_data;
    }

    private selected_day: {id: number, name: string} = null
    
    private loading = false;

    private day_facility_list = []

    private new_dispo = []

    private new_images = []

    private images_list: {id: number, image: string}[] = []

    private facility_infos: FacilityInterface = {
        name: "",
        description: "",
        max_customers: 0
    }

    private day_facility_infos = {
        start: "",
        end: ""
    }

    private days: {id: number, name: string}[] = []

    private formatDate(date: any): string {
        return date.toDateString();
    }

    private async save() {
        const headers = {headers: {"Authorization": "Bearer " + this.user.api_token}}

        if(this.news) {
            await axios.post(`http://127.0.0.1:8000/api/facilities/store`, this.facility_infos, headers)
            .then( async (res: any) => {

                if(res.data.success) {
                    
                    const facility_id = res.data.success.id;
                    
                    let images = []

                    for (const image of this.images_list) {
                        images.push(image.image)
                    }

                    await axios.post(`http://127.0.0.1:8000/api/facilitiesImage/${facility_id}/store`, {images: images}, headers)

                    for (const day_facility of this.day_facility_list) {
                        const day_id = day_facility.id;

                        for (const dispo of day_facility.dispos) {
                            
                            await axios.post(`http://127.0.0.1:8000/api/dayFacility/${day_id}/${facility_id}/store`, dispo, headers)
                            .then((res: any) => console.log(res))
                        }
                    }
                } else console.log(res)
            })
        } else {
            await axios.put(`http://127.0.0.1:8000/api/facilities/${this.facility.id}/update`, this.facility_infos, headers)
                .then( async (res: any) => {

                    if(res.data.success) {
                        
                        for(const image of this.images_to_delete) {
                            await axios.delete(`http://127.0.0.1:8000/api/facilitiesImage/${image}/destroy`, headers)
                        }

                        for(const dispo of this.dispos_to_delete) {
                            await axios.delete(`http://127.0.0.1:8000/api/dayFacility/${dispo}/destroy`, headers)
                        }

                        let images = []

                        for (const image of this.new_images) {
                            images.push(image.image)
                        }

                        await axios.post(`http://127.0.0.1:8000/api/facilitiesImage/${this.facility.id}/store`, {images: images}, headers)
                        

                        for (const day_facility of this.new_dispo) {
                            const day_id = day_facility.day;
 
                            await axios.post(`http://127.0.0.1:8000/api/dayFacility/${day_id}/${this.facility.id}/store`, day_facility, headers)
                            .then((res: any) => console.log(res))
                        }
                    } else console.log(res)
                })

        }

        await this.$store.dispatch('update', 'facilities');
        this.$emit('done')
    }

    private async deleteFacility() {
        const headers = {headers: {"Authorization": "Bearer " + this.user.api_token}}
        await axios.delete(`http://127.0.0.1:8000/api/facilities/${this.facility.id}/destroy`, headers)
        .then( async (res: any) => {
            if(res.data.success) {
                await this.$store.dispatch('update', 'facilities');
                this.$emit('done')
            }
        })
    }

    private days_to_delete: number[] = []
    private dispos_to_delete: number[] = []
    private images_to_delete: number[] = []


    private deleteDayFacilityDispo(day_facility, dispo) {
        
        const day_facility_index = this.day_facility_list.indexOf(day_facility);
        const dispo_index = this.day_facility_list[day_facility_index].dispos.indexOf(dispo);

        this.day_facility_list[day_facility_index].dispos.splice(dispo_index, 1)

        if(this.day_facility_list[day_facility_index].dispos.length == 0) {
            this.day_facility_list.splice(day_facility_index, 1);

        }
        if(!this.news) this.dispos_to_delete.push(day_facility.id)

    }

    private deleteImage(image: any) {
        if(!this.news) {
            this.images_to_delete.push(image.id)
        }

        const index = this.images_list.indexOf(image)
        this.images_list.splice(index, 1);

    }

    private addDayFacility() {
        const day = this.selected_day;
        const from = this.day_facility_infos.start.split(':')
        const to = this.day_facility_infos.end.split(':')

        const day_facility = this.day_facility_list.find((x: any) => x.id == day.id);

        
        if(!day_facility) {
            this.day_facility_list.push({
                id: day.id,
                day: day.name,
                dispos: [
                    {start_hour: Number.parseInt(from[0]), start_minute: Number.parseInt(from[1]),
                     end_hour: Number.parseInt(to[0]), end_minute: Number.parseInt(to[1])}
                ]
            })

            this.new_dispo.push( {start_hour: Number.parseInt(from[0]), start_minute: Number.parseInt(from[1]),
                     end_hour: Number.parseInt(to[0]), end_minute: Number.parseInt(to[1]), day: day.id})
        } else {
            const index = this.day_facility_list.indexOf(day_facility)

            if(this.day_facility_list[index].dispos.length < 2) {
                this.day_facility_list[index].dispos.push(
                    {start_hour: Number.parseInt(from[0]), start_minute: Number.parseInt(from[1]),
                    end_hour: Number.parseInt(to[0]), end_minute: Number.parseInt(to[1])}
                )

                this.new_dispo.push(  {start_hour: Number.parseInt(from[0]), start_minute: Number.parseInt(from[1]),
                    end_hour: Number.parseInt(to[0]), end_minute: Number.parseInt(to[1]), day: day.id})
            }
        }

        this.day_facility_infos = {
            start: "",
            end: ""
        }
    }

    private checkTo() {
        const value: string = this.day_facility_infos.end;

        if(value.length == 2) {
            this.day_facility_infos.end += ":"
        }

        if(value.length >= 3) {
            let new_h = value.split(':')[0]
            let new_m = value.split(':')[1]

            if(Number.parseInt(new_h) > 23) new_h = "23"
            if(Number.parseInt(new_m) > 59) new_m = "59"

            if(!new_m) new_m = ""
            if(!new_h) new_h = ""


            this.day_facility_infos.end = `${new_h}:${new_m}`;
        }

    }

    private checkFrom() {
        
        const value: string = this.day_facility_infos.start;

        if(value.length == 2) {
            this.day_facility_infos.start += ":"
        }

        if(value.length >= 3) {
            let new_h = value.split(':')[0]
            let new_m = value.split(':')[1]

            if(Number.parseInt(new_h) > 23) new_h = "23"
            if(Number.parseInt(new_m) > 59) new_m = "59"

            if(!new_m) new_m = ""
            if(!new_h) new_h = ""


            this.day_facility_infos.start = `${new_h}:${new_m}`;
        }

    }

    private async insertImage(event: any) {
        let reader = new FileReader();

        reader.onloadend = async (evt: any) => {
            if(evt.target.readyState == FileReader.DONE) {
                this.images_list.push({
                    id: this.images_list.length,
                    image: reader.result as string
                })

                this.new_images.push({
                    id: this.images_list.length,
                    image: reader.result as string
                })
            }
        }
        await reader.readAsDataURL(event.target.files[0])
    }

    private async mounted() {
        if(!this.news) {
            this.facility_infos = JSON.parse(JSON.stringify(this.facility));

            for (const image of this.facility.facilities_images) {
                this.images_list.push({id: image.id, image: image.storage_path})
            }

            for (const day of this.facility.days) {
                const day_facility = this.day_facility_list.find((x: any) => x.day == day.name);

                if(!day_facility) {
                    this.day_facility_list.push({
                        id: day.pivot.id,
                        day: day.name,
                        dispos: [
                            {start_hour: day.pivot.start_hour, start_minute: day.pivot.start_minute,
                            end_hour: day.pivot.end_hour, end_minute: day.pivot.end_minute}
                        ]
                    })
                } else {
                    const index = this.day_facility_list.indexOf(day_facility)

                    if(this.day_facility_list[index].dispos.length < 2) {
                        this.day_facility_list[index].dispos.push(
                           {start_hour: day.pivot.start_hour, start_minute: day.pivot.start_minute,
                            end_hour: day.pivot.end_hour, end_minute: day.pivot.end_minute}
                        )
                    }
                }
            }
        }

        await axios.get(`http://localhost:8000/api/days`, {headers: {
            'Authorization': 'Bearer ' + this.user.api_token
        }}).then((res:any) => {
            if(res.data.success) {
                this.days = res.data.success;
            } else console.log(res)
        })
    }
}
</script>

<style>
    .image-container {
        display: flex;
        padding: 20px 10px 20px 10px;
        overflow: auto;
    }

    .image {
        margin-right: 10px;
    }

    .image-title {
        font-weight: bold;
        font-size: 20px;
    }

    .image-add-container {
        margin: 15px 0 0 0;
    }
</style>