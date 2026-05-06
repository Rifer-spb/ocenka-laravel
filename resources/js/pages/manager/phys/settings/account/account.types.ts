export interface IProfile {
    first_name: string | null;
    second_name: string | null;
    last_name: string | null;
    holiday_from: Date | null;
    holiday_to: Date | null;
}

export interface IPhones {
    id: Number;
    phone: string;
}
