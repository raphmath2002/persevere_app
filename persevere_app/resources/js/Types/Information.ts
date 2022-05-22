export interface InformationInterface {
    id?: number;
  
    title: string;
    markdown: string;

    readed?: boolean;
    created_at?: string;
    updated_at?: string;
}

export default class Information implements InformationInterface {
    id?: number;

    title: string;
    markdown: string;

    readed?: boolean;
    created_at?: string;
    updated_at?: string;

    constructor(information: InformationInterface) {
        this.id = information.id;

        this.title = information.title;
        this.markdown = information.markdown;
        this.readed = information.readed;

        this.created_at = information.created_at;
        this.updated_at = information.updated_at;
    }

    static emptyInformation(): InformationInterface {
        return {
            markdown: "",
            title: ""
        }
    }
}

