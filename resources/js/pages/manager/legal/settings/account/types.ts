export type TType = {
    id: number;
    name: string;
    shortName: string;
}

export type TCompany = {
    typeId: number | null;
    shortName: string | null;
    abbr: string | null;
    address: string | null;
    dateOgrn: string | null;
    inn: number | null;
    kpp: number | null;
    ogrn: number | null;
}
