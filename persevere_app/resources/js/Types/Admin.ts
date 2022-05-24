import User, {UserInterface} from "./User"
import Appointment, {AppointmentInterface} from "./Appointment"
import Facility, {FacilityInterface} from "./Facility"
import Horse, {HorseInterface} from "./Horse"
import Information, {InformationInterface} from "./Information"
import Message, {MessageInterface} from "./Message"
import Option, {OptionInterface} from "./Options"
import Pension, {PensionInterface} from "./Pension"
import Professional, {ProfessionalInterface} from "./Professional"
import Ticket, {TicketInterface} from "./Ticket"

import store from '../Store'
import axios from 'axios'


interface AdminInterface {
    users: UserInterface[];
    horses: HorseInterface[];
    appointments: AppointmentInterface[];
    facilities: FacilityInterface[];
    advertisements: InformationInterface[];
    tickets: TicketInterface[];
    options: OptionInterface[];
    pensions: PensionInterface[];
    professionals: ProfessionalInterface[];
}

export default class Admin implements AdminInterface {
    public users: UserInterface[] = [];
    public horses: HorseInterface[] = [];
    public appointments: AppointmentInterface[] = [];
    public facilities: FacilityInterface[] = [];
    public advertisements: InformationInterface[] = [];
    public tickets: TicketInterface[] = [];
    public options: OptionInterface[] = [];
    public pensions: PensionInterface[] = [];
    public professionals: ProfessionalInterface[] = [];

    _apiToken = store.state.user.api_token;

    constructor(){}

    public async updateUsersData() {
        
    }

    public async updateHorsesData() {
        let {data} = await axios.get('http://localhost:8000/api/horses', {
            headers: {
                "Authorization": "Bearer " + this._apiToken
            }
        })

        if(data.success) this.horses = data.success;
    }

    public async updateAppointmentsData() {
        let {data} = await axios.get('http://localhost:8000/api/appointments', {
            headers: {
                "Authorization": "Bearer " + this._apiToken
            }
        })

        if(data.success) this.appointments = data.success;
    }

    public async updateFacilitiesData() {
        let {data} = await axios.get('http://localhost:8000/api/facilities', {
            headers: {
                "Authorization": "Bearer " + this._apiToken
            }
        })

        if(data.success) this.facilities = data.success;
    }

    public async updateAdvertisementsData() {
        let {data} = await axios.get('http://localhost:8000/api/advertisements', {
            headers: {
                "Authorization": "Bearer " + this._apiToken
            }
        })

        if(data.success) this.advertisements = data.success;
    }

    public async updateTicketsData() {
        let {data} = await axios.get('http://localhost:8000/api/tickets', {
            headers: {
                "Authorization": "Bearer " + this._apiToken
            }
        })

        if(data.success) this.tickets = data.success;
    }

    public async updateOptionsData() {
        let {data} = await axios.get('http://localhost:8000/api/options', {
            headers: {
                "Authorization": "Bearer " + this._apiToken
            }
        })

        if(data.success) this.options = data.success;
    }

    public async updatePensionsData() {
        let {data} = await axios.get('http://localhost:8000/api/pensions', {
            headers: {
                "Authorization": "Bearer " + this._apiToken
            }
        })

        if(data.success) this.pensions = data.success;
    }

    public async updateProfessionalsData() {
        let {data} = await axios.get('http://localhost:8000/api/professionals', {
            headers: {
                "Authorization": "Bearer " + this._apiToken
            }
        })

        if(data.success) this.professionals = data.success;
    }

    public async updateAll() {
        store.state.admin_data_loading = true;

        await this.updateUsersData();
        await this.updateAppointmentsData();
        await this.updateAdvertisementsData();
        await this.updateFacilitiesData();
        await this.updateHorsesData();
        await this.updateOptionsData();
        await this.updatePensionsData();
        await this.updateProfessionalsData();
        await this.updateTicketsData();

        store.state.admin_data_loading = false;
    }
}