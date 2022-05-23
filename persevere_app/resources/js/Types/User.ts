import { HorseInterface } from "./Horse";
import { OptionInterface } from "./Options";
import { PensionInterface } from "./Pension";

import axios from 'axios'

export interface UserInterface {
    id?: number;

    name: string;
    firstname: string;
    email: string;
    phone: string;
    postal_code: string;
    postal_address: string;
    city: string;
    country: string;
    birth_date: string;
    storage_path: string;
    auth_level: string;

    horses?: HorseInterface[];
    api_token?: string;
    created_at?: string;
    updated_at?: string;
}

export default class User implements UserInterface {
    id?: number;

    name: string;
    firstname: string;
    email: string;
    phone: string;
    postal_code: string;
    postal_address: string;
    city: string;
    country: string;
    birth_date: string;
    storage_path: string;
    auth_level: string;

    horses?: HorseInterface[];
    api_token?: string;
    created_at?: string;
    updated_at?: string;

    constructor(user: UserInterface) {
        this.id = user.id;

        this.name = user.name;
        this.firstname = user.firstname;
        this.email = user.email;
        this.phone = user.phone;
        this.postal_code = user.postal_code;
        this.postal_address = user.postal_address;
        this.city = user.city;
        this.birth_date = user.birth_date;
        this.storage_path = user.storage_path;
        this.auth_level = user.auth_level;
        this.horses = user.horses;
        
        this.api_token = user.api_token;
        this.created_at = user.created_at;
        this.updated_at = user.updated_at;
    }
    
}

export function emptyUser(): UserInterface {
    return {
        name: "",
        firstname: "",
        email: "",
        phone: "",
        postal_code: "",
        postal_address: "",
        city: "",
        country: "",
        birth_date: "",
        storage_path: "",
        auth_level: ""
    }
}

export async function updateUsers(): Promise<void> {
    let {data} = await axios.get('http://localhost:8000/api/users', {
            headers: {
                "Authorization": "Bearer " + this._apiToken
            }
        })
    if(data.success) this.users = data.success;
}

