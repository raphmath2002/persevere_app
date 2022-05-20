export interface PensionInterface {
    id?: number;

    name: string;
    price: number;
    description: string;

    created_at?: number;
    updated_at?: number;
}

export default class Pension implements PensionInterface {
    id?: number;

    name: string;
    price: number;
    description: string;

    created_at?: number;
    updated_at?: number;

    constructor(pension: PensionInterface) {
        this.id = pension.id;

        this.name = pension.name;
        this.description = pension.description;
        this.price = pension.price;
        
        this.created_at = pension.created_at;
        this.updated_at = pension.updated_at;
    }
}

