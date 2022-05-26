export interface FacilityInterface {
    id?: number;
    name: string;
    description: string;
    max_customers: number;
    facilities_images?: any[];
    days?: any;
    created_at?: string;
    updated_at?: string;
}

export default class Facility implements FacilityInterface {
    id?: number;
    name: string;
    description: string;
    max_customers: number;
    facilities_images?: any[];
    days?: any;
    created_at?: string;
    updated_at?: string;

    constructor(facility: FacilityInterface) {
        this.id = facility.id;
        this.name = facility.name;
        this.description = facility.description;
        this.max_customers = facility.max_customers;
        this.days = facility.days;
        this.created_at = facility.created_at;
        this.updated_at = facility.updated_at;
    }
}

