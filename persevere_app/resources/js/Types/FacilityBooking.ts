export interface FacilityBookingInterface {
    id?: number;

    book_date: string;
    book_from: string;
    book_to: string;

    user_id: number;
    facility_id: number;
    horse_id: number;

    created_at?: number;
    updated_at?: number;
}

export default class FacilityBooking implements FacilityBookingInterface {
    id?: number;

    book_date: string;
    book_from: string;
    book_to: string;

    user_id: number;
    facility_id: number;
    horse_id: number;

    created_at?: number;
    updated_at?: number;

    constructor(facilityBooking: FacilityBookingInterface) {
        this.id = facilityBooking.id;

        this.book_date = facilityBooking.book_date;
        this.book_from = facilityBooking.book_from;
        this.book_to = facilityBooking.book_to;

        this.user_id = facilityBooking.user_id;
        this.horse_id = facilityBooking.horse_id;
        this.facility_id = facilityBooking.facility_id;

        this.created_at = facilityBooking.created_at;
        this.updated_at = facilityBooking.updated_at;
    }
}

