export type TNotary = {
    id: number;
    region: { name: string };
    name: string;
    address: string;
    comment: string;
    phones: Array<{phone: string}>;
    emails: Array<{email: string}>;
};

export type TCurrentNotary = {
    id: number;
    emails: Array<string>;
    site: string;
    useDigitalReport: number;
    comment: string;
};
