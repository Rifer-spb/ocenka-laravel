export interface Profile {
    first_name: string | null;
    second_name: string | null;
    last_name: string | null;
    holiday_from: Date | null;
    holiday_to: Date | null;
}

export interface Phones {
    id: Number;
    phone: string;
}
