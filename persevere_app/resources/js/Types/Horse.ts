export interface HorseInterface {
    id?: number;

    name: string;
    size: number;
    weigth: number;
    birth_date: string;
    sire_code: string;
    ueln_code: string;
    birth_country: string;
    avatar_path: string;

    user_id: number;
    created_at?: number;
    updated_at?: number;
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
    avatar_path: string;

    user_id: number;
    created_at?: number;
    updated_at?: number;

    constructor(horse: HorseInterface) {
        this.id = horse.id;
        
        this.name = horse.name;
        this.size = horse.size;
        this.weigth = horse.weigth;
        this.birth_date = horse.birth_date;
        this.sire_code = horse.sire_code;
        this.ueln_code = horse.ueln_code;
        this.avatar_path = horse.avatar_path;
        this.birth_date = horse.birth_date;
        this.birth_country = horse.birth_country;

        this.user_id = horse.user_id;
        this.created_at = horse.created_at;
        this.updated_at = horse.updated_at;
    }
}

