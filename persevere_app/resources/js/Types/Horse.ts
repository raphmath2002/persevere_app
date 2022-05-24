import { OptionInterface } from "./Options";
import { PensionInterface } from "./Pension";

export interface HorseInterface {
    id?: number;

    name: string;
    size: number;
    weigth: number;
    birth_date: string;
    sire_code: string;
    ueln_code: string;
    birth_country: string;
    storage_path: string;
    sex: string;

    pension: PensionInterface;
    options: OptionInterface[];
    user_id: number;
    appointments?: string;
    created_at?: string;
    updated_at?: string;
}

export default class Horse implements HorseInterface {
    id?: number;

    name: string;
    size: number;
    weigth: number;
    birth_date: string;
    sire_code: string;
    ueln_code: string;
    birth_country: string;
    storage_path: string;
    sex: string;

    options: OptionInterface[];
    pension: PensionInterface;
    user_id: number;
    appointments?: string;
    created_at?: string;
    updated_at?: string;

    constructor(horse: HorseInterface) {
        this.id = horse.id;
        
        this.name = horse.name;
        this.size = horse.size;
        this.weigth = horse.weigth;
        this.birth_date = horse.birth_date;
        this.sire_code = horse.sire_code;
        this.ueln_code = horse.ueln_code;
        this.storage_path = horse.storage_path;
        this.birth_date = horse.birth_date;
        this.birth_country = horse.birth_country;
        this.sex = horse.sex;

        this.options = horse.options;
        this.pension = horse.pension;
        this.user_id = horse.user_id;
        this.appointments = horse.appointments;
        this.created_at = horse.created_at;
        this.updated_at = horse.updated_at;
    }

    static emptyHorse(): Horse {
        return new Horse(
            {
                id: 0,

                name: "",
                size: 0,
                weigth: 0,
                birth_date: "",
                sire_code: "",
                ueln_code: "",
                birth_country: "",
                storage_path: "",
                sex: "",
                options: [],
                pension: null,

                user_id: 0,
                created_at: "",
                updated_at: "",
            }
        )
    }
}

