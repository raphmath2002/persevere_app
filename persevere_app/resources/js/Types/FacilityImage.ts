export interface FacilityImageInterface {
    id?: number;

    path: string;
    size: number;
    weigth: number;
    type: string;

    facility_id: number;
    created_at?: number;
    updated_at?: number;
}

export default class FacilityImage implements FacilityImageInterface {
    id?: number;

    path: string;
    size: number;
    weigth: number;
    type: string;

    facility_id: number;
    created_at?: number;
    updated_at?: number;

    constructor(facilityImage: FacilityImageInterface) {
        this.id = facilityImage.id;

        this.path = facilityImage.path;
        this.size = facilityImage.size;
        this.weigth = facilityImage.weigth;
        this.type = facilityImage.type;
        
        this.facility_id = facilityImage.facility_id;
        this.created_at = facilityImage.created_at;
        this.updated_at = facilityImage.updated_at;
    }
}

