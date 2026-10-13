type TTemplate = {
    id: number;
    name: string;
    text: string;
};

type TTemplateForm = {
    method: 'post' | 'patch';
    action: string;
    name: TTemplate['name'];
    text: TTemplate['text'];
};
