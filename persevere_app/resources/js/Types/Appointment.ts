import { ProfessionalInterface } from "./Professional";

export interface AppointmentInterface {
    id?: number;

    duration: number;
    start_date: string;
    end_date: string;
    max_appointments: string;
    professional_id: number;

    professional?: ProfessionalInterface;
    created_at?: string;
    updated_at?: string;
}

export default class Appointment implements AppointmentInterface {
    id?: number;

    duration: number;
    price: number;
    start_date: string;
    end_date: string;
    max_appointments: string;
    professional_id: number;

    professional?: ProfessionalInterface;
    created_at?: string;
    updated_at?: string;

    constructor(appointment: AppointmentInterface) {
        this.id = appointment.id;
        
        this.duration = appointment.duration;
        this.start_date = appointment.start_date;
        this.max_appointments = appointment.max_appointments;
        this.professional_id = appointment.professional_id;
        this.end_date = appointment.end_date;

        this.professional = appointment.professional;
        this.created_at = appointment.created_at;
        this.updated_at = appointment.updated_at;
    }
}

