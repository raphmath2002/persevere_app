import { MessageInterface } from "./Message";

export interface TicketInterface {
    id?: number;
    title: string;

    messages: MessageInterface[],
  
    user_id: number;
    created_at?: string;
    updated_at?: string;
}

export default class Ticket implements TicketInterface {
    id?: number;
    title: string;
    messages: MessageInterface[];
    user_id: number;
    created_at?: string;
    updated_at?: string;

    constructor(ticket: TicketInterface) {
        this.id = ticket.id;
        this.title = ticket.title;
        this.user_id = ticket.user_id;
        this.created_at = ticket.created_at;
        this.updated_at = ticket.updated_at;
        this.messages = ticket.messages;
    }
}

