export interface InformationInterface {
    id?: number;
    content: string;
  
    markdown: string;

    created_at?: string;
    updated_at?: string;
}

export default class Information implements InformationInterface {
    id?: number;
    content: string;
  
    markdown: string;
    
    created_at?: string;
    updated_at?: string;

    constructor(information: InformationInterface) {
        this.id = information.id;
        this.content = information.content;

       this.markdown = information.markdown;

        this.created_at = information.created_at;
        this.updated_at = information.updated_at;
    }
}

