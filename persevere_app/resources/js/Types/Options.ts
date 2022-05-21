import { HorseInterface } from "./Horse";

export interface OptionInterface {
    id?: number;

    name: string;
    price: number;
    description: string;

    horse?: HorseInterface;
    created_at?: string;
    updated_at?: string;
}

export default class Option implements OptionInterface {
    id?: number;
    
    name: string;
    price: number;
    description: string;

    horse?: HorseInterface;
    created_at?: string;
    updated_at?: string;

    constructor(option: OptionInterface) {
        this.id = option.id;

        this.name = option.name;
        this.description = option.description;
        this.price = option.price;
        this.horse = option.horse;

        this.created_at = option.created_at;
        this.updated_at = option.updated_at;
    }
}

