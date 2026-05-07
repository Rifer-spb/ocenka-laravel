export type TType = {
    id: number;
    name: string;
    shortName: string;
}

export type TCompany = {
    typeId: number | null;
    fullName: string | null;
    shortName: string | null;
    abbr: string | null;
    address: string | null;
    dateOgrn: Date | null;
    inn: number | null;
    kpp: number | null;
    ogrn: number | null;
}
