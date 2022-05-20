export interface FacilityInterface {
    id?: number;
    name: string;
    description: string;
    max_customer_allowed: number;
    created_at?: number;
    updated_at?: number;
}

export default class Facility implements FacilityInterface {
    id?: number;
    name: string;
    description: string;
    max_customer_allowed: number;
    created_at?: number;
    updated_at?: number;

    constructor(facility: FacilityInterface) {
        this.id = facility.id;
        this.name = facility.name;
        this.description = facility.description;
        this.max_customer_allowed = facility.max_customer_allowed;
        this.created_at = facility.created_at;
        this.updated_at = facility.updated_at;
    }
}

