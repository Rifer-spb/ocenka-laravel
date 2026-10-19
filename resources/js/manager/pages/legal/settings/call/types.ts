export type TTemplate = {
    id: number;
    name: string;
    text: string;
};

export type TTemplateForm = {
    method: 'post' | 'patch';
    action: string;
    name: TTemplate['name'];
    text: TTemplate['text'];
};

export type TPhone = {
    id: number;
    phone: string;
};

export type TEmployees = {
    id: number;
    name: string;
    canCall: boolean;
    phoneExtension: string;
}
