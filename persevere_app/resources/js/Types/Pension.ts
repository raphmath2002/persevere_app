import { HorseInterface } from "./Horse";

export interface PensionInterface {
    id?: number;

    name: string;
    price: number;
    description: string;

    horse?: HorseInterface;
    created_at?: string;
    updated_at?: string;
}

export default class Pension implements PensionInterface {
    id?: number;

    name: string;
    price: number;
    description: string;

    horse?: HorseInterface;
    created_at?: string;
    updated_at?: string;

    constructor(pension: PensionInterface) {
        this.id = pension.id;

        this.name = pension.name;
        this.description = pension.description;
        this.price = pension.price;
        
        this.horse = pension.horse;
        this.created_at = pension.created_at;
        this.updated_at = pension.updated_at;
    }
}

