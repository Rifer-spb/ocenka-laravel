export type TFilter = {
    name?: string;
    address?: string;
    email?: string;
    notWork: boolean;
}

export type TNotary = {
    id: number;
    region: { name: string };
    name: string;
    address: string;
    comment?: string;
    phones: Array<{phone: string}>;
    emails: Array<{email: string}>;
}
