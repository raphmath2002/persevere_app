export interface MessageInterface {
    id?: number;
    content: string;
  
    ticket_id: number;
    user_id: number;

    created_at?: number;
    updated_at?: number;
}

export default class Message implements MessageInterface {
    id?: number;
    content: string;
  
    ticket_id: number;
    user_id: number;
    
    created_at?: number;
    updated_at?: number;

    constructor(message: MessageInterface) {
        this.id = message.id;
        this.content = message.content;

        this.ticket_id = message.ticket_id;
        this.user_id = message.user_id;

        this.created_at = message.created_at;
        this.updated_at = message.updated_at;
    }
}

