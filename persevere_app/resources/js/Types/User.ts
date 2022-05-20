export interface UserInterface {
    id?: number;

    name: string;
    surname: string;
    mail: string;
    phone: string;
    postal_code: string;
    postal_address: string;
    city: string;
    birth_date: string;
    birth_country: string;
    avatar_path: string;
    auth_level: string;
    profession?: string;
    
    created_at?: number;
    updated_at?: number;
}

export default class User implements UserInterface {
    id?: number;

    name: string;
    surname: string;
    mail: string;
    phone: string;
    postal_code: string;
    postal_address: string;
    city: string;
    birth_date: string;
    birth_country: string;
    avatar_path: string;
    auth_level: string;
    profession?: string;

    created_at?: number;
    updated_at?: number;

    constructor(user: UserInterface) {
        this.id = user.id;

        this.name = user.name;
        this.surname = user.surname;
        this.mail = user.mail;
        this.phone = user.phone;
        this.postal_code = user.postal_code;
        this.postal_address = user.postal_address;
        this.city = user.city;
        this.birth_date = user.birth_date;
        this.birth_country = user.birth_country;
        this.avatar_path = user.avatar_path;
        this.auth_level = user.auth_level;
        this.profession = user.profession;

        this.created_at = user.created_at;
        this.updated_at = user.updated_at;
    }
}

