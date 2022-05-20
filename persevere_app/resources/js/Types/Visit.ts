export interface VisitInterface {
    id?: number;

    service_duration: number;
    price: number;
    visit_date: string;
    visit_from: string;
    visit_to: string;
    max_appointments: string;

    professional_id: number;
    created_at?: number;
    updated_at?: number;
}

export default class Visit implements VisitInterface {
    id?: number;

    service_duration: number;
    price: number;
    visit_date: string;
    visit_from: string;
    visit_to: string;
    max_appointments: string;

    professional_id: number;
    created_at?: number;
    updated_at?: number;

    constructor(visit: VisitInterface) {
        this.id = visit.id;
        
        this.service_duration = visit.service_duration;
        this.price = visit.price;
        this.visit_date = visit.visit_date;
        this.visit_from = visit.visit_from;
        this.visit_to = visit.visit_to;
        this.max_appointments = visit.max_appointments;

        this.professional_id = visit.professional_id;
        this.created_at = visit.created_at;
        this.updated_at = visit.updated_at;
    }
}

