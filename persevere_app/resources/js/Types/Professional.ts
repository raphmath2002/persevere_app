export interface ProfessionalInterface {
    id?: number;
    name: string;
    firstname: string;
    email: string;
    phone: string;
    profession: string;
    postal_code: string;
    postal_address: string;
    city: string;
    country: string;
    birth_date: string;
    storage_path: string;

    created_at?: string;
    updated_at?: string;
}

export default class Professional implements ProfessionalInterface {
    id?: number;

    name: string;
    firstname: string;
    profession: string;
    email: string;
    phone: string;
    postal_code: string;
    postal_address: string;
    city: string;
    country: string;
    birth_date: string;
    storage_path: string;

    created_at?: string;
    updated_at?: string;

    constructor(professional: ProfessionalInterface) {
        this.id = professional.id;
        
        this.name = professional.name;
        this.firstname = professional.firstname;
        this.email = professional.email;
        this.phone = professional.phone;
        this.postal_code = professional.postal_code;
        this.postal_address = professional.postal_address;
        this.city = professional.city;
        this.birth_date = professional.birth_date;
        this.storage_path = professional.storage_path;
        this.profession = professional.profession;

        this.created_at = professional.created_at;
        this.updated_at = professional.updated_at;
    }
}

