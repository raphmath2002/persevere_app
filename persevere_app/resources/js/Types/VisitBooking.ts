export interface VisitBookingInterface {
    id?: number;

    appointment_to: string;
    appointment_from: string;
    status: string;
    observations?: string;
    ended_at?: string;
    treatment?: string;
    customer_details: string;

    professional_id: number;
    horse_id: number;
    user_id: number;

    created_at?: number;
    updated_at?: number;
}

export default class VisitBooking implements VisitBookingInterface {
   id?: number;

    appointment_to: string;
    appointment_from: string;
    status: string;
    observations?: string;
    ended_at?: string;
    treatment?: string;
    customer_details: string;

    professional_id: number;
    horse_id: number;
    user_id: number;
    
    created_at?: number;
    updated_at?: number;

    constructor(visitBooking: VisitBookingInterface) {
        this.id = visitBooking.id;
        
        this.appointment_to = visitBooking.appointment_to;
        this.appointment_from = visitBooking.appointment_from;
        this.status = visitBooking.status;
        this.observations = visitBooking.observations;
        this.ended_at = visitBooking.ended_at;
        this.treatment = visitBooking.treatment;
        this.customer_details = visitBooking.customer_details;

        this.professional_id = visitBooking.professional_id;
        this.horse_id = visitBooking.horse_id;
        this.user_id = visitBooking.user_id;
        
        this.created_at = visitBooking.created_at;
        this.updated_at = visitBooking.updated_at;
    }
}

